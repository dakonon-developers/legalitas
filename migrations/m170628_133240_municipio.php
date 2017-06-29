<?php

use yii\db\Migration;

class m170628_133240_municipio extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%municipio}}',[
            'id' => $this->primaryKey(),
            'fk_provincia' => $this->integer()->notNull(),
            'nombre' => $this->string(128)->notNull(),
            ], $tableOptions);

        $this->createIndex('i-fk_provincia','municipio','fk_provincia');
        $this->addForeignKey('municipio_provincia','municipio','fk_provincia','provincia','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%municipio}}');
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
