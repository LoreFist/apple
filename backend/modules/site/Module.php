<?php

namespace app\modules\site;

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
            'login'  => 'site/default/login',
            'logout' => 'site/default/logout',
            'error'  => 'site/default/error'
        ], false);
    }
}