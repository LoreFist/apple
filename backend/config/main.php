<?php

use yii\helpers\ArrayHelper;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$db = ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/db.php'),
    require(__DIR__ . '/../../common/config/db-local.php')
);

return [
    'id'                  => 'app-backend',
    'name'                => 'Apple Backend',
    'basePath'            => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap'           => ['log', 'site', 'apple'],
    'modules'             => [
        'site'  => [
            'class' => 'app\modules\site\Module',
        ],
        'apple' => [
            'class' => 'app\modules\apple\Module',
        ],
    ],
    'components'          => [
        'db'           => $db,
        'request'      => [
            'csrfParam' => '_csrf-backend',
        ],
        'user'         => [
            'identityClass'   => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie'  => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl'        => '/login',
        ],
        'session'      => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => '/error',
        ],
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => require __DIR__ . DIRECTORY_SEPARATOR . 'rules.php',
        ],
        'view'         => [
            'theme' => [
                'basePath' => '@app/themes/main',
                'baseUrl'  => '@web/themes/main',
                'pathMap'  => [
                    '@app/views' => '@app/themes/main/views',
                ],
            ]
        ]
    ],
    'params'              => $params,
];
