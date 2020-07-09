<?php

namespace backend\themes\main\assets;

use yii\bootstrap4\BootstrapAsset;
use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl  = '@web';
    public $css      = [
        'css/site.css',
    ];
    public $js       = [
    ];
    public $depends  = [
        'yii\web\YiiAsset',
        BootstrapAsset::class
    ];
}
