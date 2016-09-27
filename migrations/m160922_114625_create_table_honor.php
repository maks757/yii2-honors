<?php

use yii\db\Migration;

class m160922_114625_create_table_honor extends Migration
{
    public function up()
    {
        $this->createTable('honor', [
            'id' => $this->primaryKey(),
            'image' => $this->string(60),
        ]);
    }

    public function down()
    {
        echo "m160922_114634_create_table_honor cannot be reverted.\n";

        $this->dropTable('honor');

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
