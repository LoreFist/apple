<?php

namespace common\models;

/**
 * This is the model class for table "apples".
 *
 * @property int         $apple_id
 * @property int|null    $user_id    пользователь владелец
 * @property string      $color      цвет
 * @property int         $status     статус
 * @property int|null    $integrity  сколько съели
 * @property string|null $drop_at    дата падения
 * @property string|null $created_at создано
 * @property string|null $updated_at обновлено
 *
 * @property Users       $userRelation
 */
class Apples extends \yii\db\ActiveRecord {
    const STATUS_IN_TREE   = 0;
    const STATUS_DROP_TREE = 1;
    const STATUS_ROTTEN    = 2;

    public static $STATUS = [
        self::STATUS_IN_TREE   => 'На дереве',
        self::STATUS_DROP_TREE => 'Лежит на земле',
        self::STATUS_ROTTEN    => 'Гнилое',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'apples';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'status', 'integrity'], 'integer'],
            [['color'], 'required'],
            [['drop_at', 'created_at', 'updated_at'], 'safe'],
            [['color'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'apple_id'   => 'Apple ID',
            'user_id'    => 'User ID',
            'color'      => 'Color',
            'status'     => 'Status',
            'integrity'  => 'Integrity',
            'drop_at'    => 'Drop At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserRelation() {
        return $this->hasOne(Users::className(), ['user_id' => 'user_id']);
    }
}
