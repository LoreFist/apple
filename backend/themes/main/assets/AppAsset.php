<?php

namespace backend\themes\main\assets;

use ruturajmaniyar\widgets\toast\assests\ToastrAsset;
use yii\bootstrap4\BootstrapAsset;
use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle {
    public $sourcePath = '@app/themes/main/assets/dist';
    public $css        = [
        'css/site.css',
    ];
    public $js         = [
        'js/theme.js'
    ];
    public $depends    = [
        'yii\web\YiiAsset',
        BootstrapAsset::class,
        ToastrAsset::class,
    ];
}
