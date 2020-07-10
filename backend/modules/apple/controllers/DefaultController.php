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
            try {
                $message = '';
                for ($i = 0; $i < $count; $i++) {
                    $apple   = new ApplesService();
                    $message .= "Создали яблоко с цветом $apple->color \r\n";
                }
                return $this->asJson([
                    'status'  => true,
                    'message' => $message
                ]);
            } catch (\Exception $e) {
                return $this->asJson([
                    'status'  => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    public function actionDrop($id) {
        if (Yii::$app->request->isAjax) {
            try {
                $result = ApplesService::setFallToGround($id);
                if ($result['status']) $message = "Яблоко успешно упало на землю";
                else $message = "Яблоко не упало на землю";
                return $this->asJson([
                    'status'  => true,
                    'message' => $message
                ]);
            } catch (\Exception $e) {
                return $this->asJson([
                    'status'  => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    public function actionEat($id, $percent = 10) {
        if (Yii::$app->request->isAjax) {
            try {
                $result = ApplesService::setEat($id, (int)$percent);
                if ($result['status']) $message = "От яблока откусили " . $result['percent'] . " %";
                else $message = "Не удалось откусить яблоко";
                return $this->asJson([
                    'status'  => true,
                    'message' => $message
                ]);
            } catch (\Exception $e) {
                return $this->asJson([
                    'status'  => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    public function actionDelete($id) {
        if (Yii::$app->request->isAjax) {
            try {
                $result = ApplesService::setDelete($id);
                if ($result['status']) $message = "Яблоко уничтожили";
                else $message = "Не удалось уничтожить яблоко";
                return $this->asJson([
                    'status'  => true,
                    'message' => $message
                ]);
            } catch (\Exception $e) {
                return $this->asJson([
                    'status'  => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }
}
