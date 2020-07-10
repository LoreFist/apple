<?php

namespace common\services;

use common\models\Apples;
use ImagickPixel;
use Yii;
use yii\base\Exception;

class ApplesService extends Apples {

    private $nameColor = null;

    /**
     * new ApplesService('color')
     *
     * ApplesService constructor.
     *
     * @param null  $nameColor
     * @param array $config
     */
    public function __construct($nameColor = null, $config = []) {
        parent::__construct($config);
        $this->nameColor = $nameColor;
        $this->create();
    }

    /**
     * ищет яблоки попадающие под условие испорченного и сохраняет его таковым
     */
    private static function checkRotten() {
        $time         = date('Y-m-d H:i:s', strtotime('-5 hours'));
        $applesRotten = Apples::find()->where(['status' => Apples::STATUS_DROP_TREE])->andWhere(['<=', 'drop_at', $time])->all();
        foreach ($applesRotten as $apple) {
            $apple->status = Apples::STATUS_ROTTEN;
            $apple->validate();
            $apple->save(false);
        }
    }

    /**
     * Генерация случайного цвета в HEX
     *
     * @return string
     */
    private static function randomColor() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    /**
     * конвертер имени цвета в HEX
     *
     * @param $nm
     *
     * @return string
     */
    private static function color2hex($nm) {
        preg_match_all("/\d{1,3}/", (new ImagickPixel ($nm))->getColorAsString(), $matches);
        [$r, $g, $b] = $matches[0];
        return sprintf("#%06X", $r * 65536 + $g * 256 + $b);
    }

    /**
     * Создание сущности Яблока
     *
     * @return Apples
     */
    public function create() {
        $this->user_id    = Yii::$app->user->id;
        $this->color      = $this->nameColor == null ? self::randomColor() : self::color2hex($this->nameColor);
        $this->status     = Apples::STATUS_IN_TREE;
        $this->created_at = date('Y-m-d H:i:s', rand(10000, strtotime('now')));
        $this->save();
        return $this;
    }

    /**
     * Положить яблоко на землю
     *
     * @throws Exception
     */
    public function fallToGround() {
        if ($this->status == Apples::STATUS_IN_TREE) {
            $this->status  = Apples::STATUS_DROP_TREE;
            $this->drop_at = date('Y-m-d H:i:s', strtotime('now'));
        }
        else
            throw new Exception('Уронить яблоко можно только когда оно весит');
    }

    /**
     * откусить часть яблока
     *
     * @param $percent
     *
     * @throws Exception
     */
    public function eat($percent) {
        if ($this->size <= 0) throw new Exception('Съесть нельзя, яблоко уже съеденно');
        elseif ($this->status == Apples::STATUS_DROP_TREE) $this->size = $this->size - $percent;
        elseif ($this->status == Apples::STATUS_ROTTEN) throw new Exception('Съесть нельзя, яблоко испорченно');
        else throw new Exception('Съесть нельзя, яблоко на дереве');
        if ($this->size <= 0) $this->size = 0;
    }

    /**
     * Удалить яблоко
     *
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function deleteA() {
        if ($this->size >= Apples::SIZE_FULL) return $this->delete();
        else throw new Exception('Яблоко нельзя удалить т.к. оно еще не до конца съеденно. Осталь ' . (Apples::SIZE_FULL - $this->size) . '%');
    }

    /**
     * @param $id
     *
     * @return array
     * @throws Exception
     */
    public static function setFallToGround($id) {
        $model = self::findOne(['apple_id' => $id]);
        $model->fallToGround();
        return ['status' => $model->save(), 'model' => $model];
    }

    /**
     * @param $id
     * @param $percent
     *
     * @return array
     * @throws Exception
     */
    public static function setEat($id, $percent) {
        self::checkRotten();
        $model   = self::findOne(['apple_id' => $id]);
        $oldSize = $model->size;
        $model->eat($percent);

        $eatPercent = $percent;
        if ($percent > $oldSize) $eatPercent = $oldSize;

        return ['status' => $model->save(), 'model' => $model, 'percent' => $eatPercent];
    }

    /**
     * @param $id
     *
     * @return array
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function setDelete($id) {
        $model  = self::findOne(['apple_id' => $id]);
        $status = $model->deleteA();
        return ['status' => $status, 'model' => $model];
    }

}