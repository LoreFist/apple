<?php

use common\models\User;
use yii\db\Migration;

class m130524_201442_init extends Migration {
    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id'                   => $this->primaryKey(),
            'username'             => $this->string()->notNull()->unique(),
            'auth_key'             => $this->string(32)->notNull(),
            'password_hash'        => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email'                => $this->string()->notNull()->unique(),

            'status'     => $this->smallInteger()->notNull()->defaultValue(User::STATUS_ACTIVE),
            'created_at' => $this->timestamp()->null()->defaultExpression('CURRENT_TIMESTAMP')->comment('создано'),
            'updated_at' => $this->timestamp()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP')->comment('обновлено'),
        ], $tableOptions);

        $modelUser           = new User();
        $modelUser->username = 'admin';
        $modelUser->setPassword('admin');
        $modelUser->generateAuthKey();
        $modelUser->email  = 'admin@admin.lcl';
        $modelUser->status = User::STATUS_ACTIVE;
        $modelUser->save();
    }

    public function down() {
        $this->dropTable('{{%user}}');
    }
}
