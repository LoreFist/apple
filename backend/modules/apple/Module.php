<?php

namespace app\modules\apple;

use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface {

    public function init() {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app) {
        $app->getUrlManager()->addRules([
            '/'      => 'apple/default/index',
            'create' => 'apple/default/create',
        ], false);
    }
}