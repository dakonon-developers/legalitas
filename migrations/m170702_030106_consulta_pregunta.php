<?php

use yii\db\Migration;

class m170702_030106_consulta_pregunta extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%consulta_pregunta}}',[
            'id' => $this->primaryKey(),
            'fk_consulta' => $this->integer()->notNull(),
            'nombre' => $this->string(128)->notNull(),
            'comentario' => $this->text()->notNull(),
            'imagen' => $this->string(128)->notNull(),
            ], $tableOptions);

        $this->createIndex('i-fk_consulta', 'consulta_pregunta', 'fk_consulta');
        $this->addForeignKey('pregunta_consulta', 'consulta_pregunta', 'fk_consulta','consulta','id','CASCADE','CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%consulta_pregunta}}');
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
