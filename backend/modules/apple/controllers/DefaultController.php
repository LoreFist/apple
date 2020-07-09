<?php

namespace app\modules\apple\controllers;

use common\models\Apples;
use common\services\ApplesService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Site controller
 */
class DefaultController extends Controller {
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'drop', 'eat', 'delete'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Apples::find()->where(['user_id' => Yii::$app->user->id]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate($count = 1) {
        if (Yii::$app->request->isAjax) {
            for ($i = 0; $i < $count; $i++) {
                $apple = new ApplesService();
                Yii::$app->session->setFlash('info', "Создали яблоко с цветов $apple->color");
            }
        }
    }

    public function actionDrop($id) {
        if (Yii::$app->request->isAjax) {
            $result = ApplesService::setFallToGround($id);
            if ($result['status']) Yii::$app->session->setFlash('success', "Яблоко успешно упало на землю");
            else Yii::$app->session->setFlash('success', "Яблоко не упало на землю");
        }
    }

    public function actionEat($id, $percent = 10) {
        if (Yii::$app->request->isAjax) {
            $result = ApplesService::setEat($id, $percent);
            if ($result['status']) $message = "От яблока откусили " . $result['model']->size . " %";
            else $message = "Не удалось откусить яблоко";
        }
    }

    public function actionDelete($id) {
        if (Yii::$app->request->isAjax) {
            $result = ApplesService::setDelete($id);
            if ($result['status']) $message = "От яблока откусили " . $result['model']->size . " %";
            else $message = "Не удалось откусить яблоко";
        }
    }
}
