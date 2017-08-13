<?php

use yii\db\Migration;

class m170813_001745_promociones extends Migration
{
     public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%promociones}}',[
            'id' => $this->primaryKey(),
            'slim' => $this->float()->notNull(),
            'med' => $this->float()->notNull(),
            'plus' => $this->float()->notNull(),
            ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%promociones}}');
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
