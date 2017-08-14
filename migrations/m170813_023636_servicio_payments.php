<?php

use yii\db\Migration;

class m170813_023636_servicio_payments extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%servicio_payments}}',[
            'id' => $this->primaryKey(),
            'fk_service' => $this->integer()->notNull(),
            'fk_users_cliente' => $this->integer()->notNull(),
            'fk_payments' => $this->integer()->notNull(),
            ], $tableOptions);

        $this->createIndex('i-fk_servicio_pay','servicio_payments','fk_service');
        $this->addForeignKey('servicio_pay','servicio_payments','fk_service','servicios','id','CASCADE','CASCADE');
        $this->createIndex('i-fk_users_pay','servicio_payments','fk_users_cliente');
        $this->addForeignKey('user_pay','servicio_payments','fk_users_cliente','perfil_usuario','id','CASCADE','CASCADE');
        $this->createIndex('i-fk_payments_serv','servicio_payments','fk_payments');
        $this->addForeignKey('payments_pay','servicio_payments','fk_payments','payments','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%servicio_payments}}');
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
