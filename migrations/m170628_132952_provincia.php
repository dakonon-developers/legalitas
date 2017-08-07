<?php

use yii\db\Migration;

class m170628_132952_provincia extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%provincia}}',[
            'id' => $this->primaryKey(),
            'fk_pais' => $this->integer()->notNull(),
            'nombre' => $this->string(128)->notNull(),
            ], $tableOptions);

        $this->createIndex('i-fk_pais_p','provincia','fk_pais');
        $this->addForeignKey('provincia_pais','provincia','fk_pais','pais','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%provincia}}');
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
