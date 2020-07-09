<?php

namespace app\modules\apple\controllers;

use common\models\Apples;
use common\services\ApplesService;
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
                        'actions' => ['index', 'create'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Apples::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate($count = 1) {
        for ($i = 0; $i < $count; $i++) {
            ApplesService::create();
        }
    }
}
