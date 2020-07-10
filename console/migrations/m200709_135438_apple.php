<?php

use yii\db\Migration;

/**
 * Class m200709_135438_apple
 */
class m200709_135438_apple extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%apples}}', [
            'apple_id'   => $this->primaryKey()->unsigned(),
            'user_id'    => $this->integer()->unsigned()->comment('пользователь владелец'),
            'color'      => $this->string()->notNull()->comment('цвет'),
            'status'     => $this->smallInteger()->notNull()->defaultValue(0)->comment('статус'),
            'size'       => $this->smallInteger()->defaultValue(100)->comment('сколько съели'),
            'drop_at'    => $this->timestamp()->comment('дата падения'),
            'created_at' => $this->timestamp()->null()->defaultExpression('CURRENT_TIMESTAMP')->comment('создано'),
            'updated_at' => $this->timestamp()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP')->comment('обновлено'),
        ]);

        $this->addForeignKey(
            'fk-apples-users',
            'apples',
            'user_id',
            'users',
            'user_id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%user}}');
    }
}
