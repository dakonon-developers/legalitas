<?php

use yii\db\Migration;

class m170702_024806_consulta extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%consulta}}',[
            'id' => $this->primaryKey(),
            'fk_cliente' => $this->integer()->notNull(),
            'fk_especialidad' => $this->integer()->notNull(),
            'fk_abogado_asignado' => $this->integer(12),
            'nombre' => $this->string(128)->notNull(),
            'descripcion' => $this->text()->notNull(),
            ], $tableOptions);

        $this->createIndex('i-fk_cliente_q', 'consulta', 'fk_cliente');
        $this->addForeignKey('consulta_cliente', 'consulta', 'fk_cliente','perfil_usuario','id','CASCADE','CASCADE');
        $this->createIndex('i-fk_especialidad_q', 'consulta', 'fk_especialidad');
        $this->addForeignKey('consulta_especialidad', 'consulta', 'fk_especialidad','especializacion','id','CASCADE','CASCADE');
        $this->createIndex('i-fk_abogado_q', 'consulta', 'fk_abogado_asignado');
        $this->addForeignKey('consulta_abogado', 'consulta', 'fk_abogado_asignado','perfil_abogado','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%consulta}}');
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
