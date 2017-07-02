<?php

use yii\db\Migration;

class m170702_030727_caso_expediente extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%caso_expediente}}',[
            'id' => $this->primaryKey(),
            'fk_consulta' => $this->integer()->notNull(),
            'archivo' => $this->string(128)->notNull(),
            ], $tableOptions);

        $this->createIndex('i-fk_caso_consulta', 'caso_expediente', 'fk_consulta');
        $this->addForeignKey('caso_consulta', 'caso_expediente', 'fk_consulta','consulta','id','CASCADE','CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%caso_expediente}}');
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
