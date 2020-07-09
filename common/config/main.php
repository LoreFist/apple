<?php

use yii\helpers\ArrayHelper;

$db = ArrayHelper::merge(
    require(__DIR__ . DIRECTORY_SEPARATOR . 'db.php'),
    require(__DIR__ . DIRECTORY_SEPARATOR . 'db-local.php')
);

return [
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db'    => $db,
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
