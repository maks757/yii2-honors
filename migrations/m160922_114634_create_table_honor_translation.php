<?php

use yii\db\Migration;

class m160922_114634_create_table_honor_translation extends Migration
{
    public function up()
    {
        $this->createTable('honor_translation',[
            'id' => $this->primaryKey(),
            'language_id' => $this->integer(11),
            'honor_id' => $this->integer(11),
            'name' => $this->string(100),
            'long_description' => $this->string(255),
            'short_description' => $this->string(100)
        ]);

        $this->addForeignKey('honor_honor_translation_fk',
            'honor_translation', 'honor_id',
            'honor', 'id',
            'CASCADE', 'CASCADE');
    }

    public function down()
    {
        echo "m160922_114625_create_table_honor_translation cannot be reverted.\n";

        $this->dropForeignKey('honor_honor_translation_fk', 'honor');

        $this->dropTable('honor_translation');

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
