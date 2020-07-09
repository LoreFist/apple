<?php

namespace app\modules\apple\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class AppleAsset extends AssetBundle {
    public $sourcePath = '@app/modules/apple/assets/dist';
    public $css        = [
    ];
    public $js         = [
        'js/apple.js'
    ];
    public $depends    = [
        JqueryAsset::class,
    ];
}
