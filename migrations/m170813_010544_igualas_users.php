<?php

use yii\db\Migration;

class m170813_010544_igualas_users extends Migration
{
     public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%igualas_users}}',[
            'id' => $this->primaryKey(),
            'fk_iguala' => $this->integer()->notNull(),
            'fk_users_cliente' => $this->integer()->notNull(),
            'slim'  => $this->boolean(),
            'med' => $this->boolean(),
            'plus' => $this->boolean(),
            'subscription_id' => $this->string(55),
            'estatus' => $this->string(55),
            // 'UNIQUE(fk_iguala, fk_users_cliente)',
            ], $tableOptions);

        $this->createIndex('i-fk_iguala_us','igualas_users','fk_iguala');
        $this->addForeignKey('iguala_user','igualas_users','fk_iguala','igualas','id','CASCADE','CASCADE');
        $this->createIndex('i-fk_user_igu','igualas_users','fk_users_cliente');
        $this->addForeignKey('user_iguala','igualas_users','fk_users_cliente','perfil_usuario','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%igualas_users}}');
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
