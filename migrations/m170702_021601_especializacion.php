<?php

use yii\db\Migration;

class m170702_021601_especializacion extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%especializacion}}',[
            'id' => $this->primaryKey(),
            'nombre' => $this->string(128)->notNull()->unique(),
            'descripcion' => $this->text()->notNull(),  
            'activo' => $this->boolean()->notNull(), 
            ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%especializacion}}');
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
