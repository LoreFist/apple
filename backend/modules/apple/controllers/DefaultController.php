<?php

namespace app\modules\apple\controllers;

use common\services\ApplesService;
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
        return $this->render('index');
    }

    public function actionCreate($count = 1) {
        for ($i = 0; $i < $count; $i++) {
            ApplesService::create();
        }
    }
}
