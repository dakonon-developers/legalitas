<?php

use yii\db\Migration;

class m170702_024256_servicios extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%servicios}}',[
            'id' => $this->primaryKey(),
            'nombre' => $this->text()->notNull(),
            'fk_materia' => $this->integer()->notNull(),
            'activo' => $this->boolean()->notNull()->defaultValue(true),
            'costo' => $this->float()->notNull(),
            ], $tableOptions);

        $this->createIndex('i-fk_materia', 'servicios', 'fk_materia');
        $this->addForeignKey('servicios_materia', 'servicios', 'fk_materia','materia','id','CASCADE','CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%servicios}}');
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
