<?php

namespace common\services;

use common\models\Apples;
use Yii;

class ApplesService extends Apples {

    /**
     * Генерация случайного цвета в HEX
     *
     * @return string
     */
    public static function randomColor() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Создание сущности Яблока
     *
     * @return Apples
     */
    public static function create() {
        $model             = new Apples();
        $model->user_id    = Yii::$app->user->id;
        $model->color      = self::randomColor();
        $model->status     = Apples::STATUS_IN_TREE;
        $model->created_at = date('Y-m-d H:i:s', rand(10000, strtotime('now')));
        $model->save();
        return $model;
    }
}