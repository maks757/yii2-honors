<?php

use yii\db\Migration;

class m160922_114634_create_table_honor extends Migration
{
    public function up()
    {
        $this->createTable('honor', [
            'id' => $this->primaryKey(),
            'image' => $this->string(60),
            'translation_id' => $this->integer(11)
        ]);

        $this->addForeignKey('honor_honor_translation_fk',
            'honor', 'translation_id',
            'honor_translation', 'id',
            'CASCADE', 'CASCADE');
    }

    public function down()
    {
        echo "m160922_114634_create_table_honor cannot be reverted.\n";

        $this->dropForeignKey('honor_honor_translation_fk', 'honor');

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
