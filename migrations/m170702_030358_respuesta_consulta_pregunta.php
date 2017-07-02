<?php

use yii\db\Migration;

class m170702_030358_respuesta_consulta_pregunta extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%respuesta_consulta_pregunta}}',[
            'id' => $this->primaryKey(),
            'fk_pregunta' => $this->integer()->notNull(),
            'respuesta' => $this->text()->notNull(),
            ], $tableOptions);

        $this->createIndex('i-fk_repuesta_pregunta', 'respuesta_consulta_pregunta', 'fk_pregunta');
        $this->addForeignKey('respuesta_pregunta', 'respuesta_consulta_pregunta', 'fk_pregunta','consulta_pregunta','id','CASCADE','CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%respuesta_consulta_pregunta}}');
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
