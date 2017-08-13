<?php

use yii\db\Migration;

class m170813_001842_igualas_servicios extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%igualas_servicios}}',[
            'fk_iguala' => $this->integer()->notNull(),
            'fk_servicio' => $this->integer()->notNull(),
            'UNIQUE(fk_iguala, fk_servicio)',
            ], $tableOptions);

        $this->createIndex('i-fk_iguala_ser','igualas_servicios','fk_iguala');
        $this->addForeignKey('iguala_servicio','igualas_servicios','fk_iguala','igualas','id','CASCADE','CASCADE');
        $this->createIndex('i-fk_servicio_iguala','igualas_servicios','fk_servicio');
        $this->addForeignKey('servicio_iguala','igualas_servicios','fk_servicio','servicios','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%igualas_servicios}}');
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
