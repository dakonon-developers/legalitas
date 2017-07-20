<?php

use yii\db\Migration;

class m170702_024116_materia extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%materia}}',[
            'id' => $this->primaryKey(),
            'nombre' => $this->string(50)->notNull()->unique(),
            ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%materia}}');
        echo "Se borro la tabla con exito.\n";
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
