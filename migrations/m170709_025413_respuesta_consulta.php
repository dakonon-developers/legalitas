<?php

use yii\db\Migration;

class m170709_025413_respuesta_consulta extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%respuesta_consulta}}',[
            'id' => $this->primaryKey(),
            'texto' => $this->text()->notNull(),
            'adjunto' => $this->string(128),
            'fecha' => $this->timestamp()->notNull(),
            'fk_abogado' => $this->integer()->notNull(),
            'fk_consulta' => $this->integer()->notNull(),
            'UNIQUE(fk_abogado,fk_consulta)',
            ], $tableOptions);

        $this->createIndex('i-respuesta_consulta_abogado', 'respuesta_consulta', 'fk_abogado');
        $this->addForeignKey('respuesta_consulta_abogado', 'respuesta_consulta', 'fk_abogado','perfil_abogado','id','CASCADE','CASCADE');
        $this->createIndex('i-respuesta_consulta_consulta', 'respuesta_consulta', 'fk_consulta');
        $this->addForeignKey('respuesta_consulta_consulta', 'respuesta_consulta', 'fk_consulta','consulta','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%respuesta_consulta}}');
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
