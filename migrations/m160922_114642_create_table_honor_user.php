<?php

use yii\db\Migration;

class m160922_114642_create_table_honor_user extends Migration
{
    public function up()
    {
        $this->createTable('honor_user', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'honor_id' => $this->integer(11),
            'date_create' => $this->integer(11),
            'date_update' => $this->integer(11),
        ]);

        $this->addForeignKey('honor_user_honor_fk',
            'honor_user', 'honor_id',
            'honor', 'id',
            'CASCADE', 'CASCADE');
    }

    public function down()
    {
        echo "m160922_114642_create_table_honor_user cannot be reverted.\n";

        $this->dropForeignKey('honor_user_honor_fk', 'honor_user');

        $this->dropTable('honor_user');

        return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
