<?php

use yii\db\Migration;

class m170813_023653_igualas_payments extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%igualas_payments}}',[
            'id' => $this->primaryKey(),
            'fk_iguala' => $this->integer()->notNull(),
            'fk_servicio_payment' => $this->integer()->notNull(),
            'mes' => $this->integer()->notNull(),
            ], $tableOptions);

        $this->createIndex('i-fk_iguala_pay','igualas_payments','fk_iguala');
        $this->addForeignKey('iguala_pay','igualas_payments','fk_iguala','igualas','id','CASCADE','CASCADE');
        $this->createIndex('i-fk_pay_users','igualas_payments','fk_servicio_payment');
        $this->addForeignKey('pay_servicio','igualas_payments','fk_servicio_payment','servicio_payments','id','CASCADE','CASCADE');

    }

     public function down()
    {
        $this->dropTable('{{%igualas_payments}}');
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
