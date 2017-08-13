<?php

use yii\db\Migration;

class m170813_054706_servicio_promocion extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%servicio_promocion}}',[
            'fk_servicio' => $this->integer()->notNull(),
            'fk_promocion' => $this->integer()->notNull(),
            'UNIQUE(fk_servicio, fk_promocion)',
            ], $tableOptions);

        $this->createIndex('i-fk_servicio_pro','servicio_promocion','fk_servicio');
        $this->addForeignKey('serv_pro','servicio_promocion','fk_servicio','servicios','id','CASCADE','CASCADE');
        $this->createIndex('i-fk_pro_serv','servicio_promocion','fk_promocion');
        $this->addForeignKey('pro_serv','servicio_promocion','fk_promocion','promociones','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%servicio_promocion}}');
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
