<?php

use yii\db\Migration;

class m170628_132446_nacionalidad extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%nacionalidad}}',[
            'id' => $this->primaryKey(),
            'fk_pais'=> $this->integer()->notNull(),
            'nombre' => $this->string(128)->notNull(),
            'abreviatura' => $this->string(3)->notNull()
            ], $tableOptions);

        $this->createIndex('i-fk_pais','nacionalidad','fk_pais');
        $this->addForeignKey('pais_nacionalidad','nacionalidad','fk_pais','pais','id','CASCADE','CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%nacionalidad}}');
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
