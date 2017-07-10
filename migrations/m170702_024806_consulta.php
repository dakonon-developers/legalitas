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
            'fk_servicio' => $this->integer()->notNull(),
            'fk_abogado_asignado' => $this->integer(12),
            'pregunta' => $this->text()->notNull(),
            'imagen' => $this->string(128),
            'finalizado' => $this->boolean()->notNull()->defaultValue(false),
            'creado_en' => $this->timestamp(),
            'fecha_fin' => $this->date(),
            ], $tableOptions);

        $this->createIndex('i-fk_cliente_q', 'consulta', 'fk_cliente');
        $this->addForeignKey('consulta_cliente', 'consulta', 'fk_cliente','perfil_usuario','id','CASCADE','CASCADE');
        $this->createIndex('i-consulta_servicio', 'consulta', 'fk_servicio');
        $this->addForeignKey('consulta_servicio', 'consulta', 'fk_servicio','servicios','id','CASCADE','CASCADE');
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
