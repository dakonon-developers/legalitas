<?php

use yii\db\Migration;

class m170709_025421_dudas extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%dudas}}',[
            'id' => $this->primaryKey(),
            'texto' => $this->text()->notNull(),
            'adjunto' => $this->string(128),
            'leido' => $this->boolean()->notNull()->defaultValue(false),
            'fecha' => $this->integer(),
            'fk_user' => $this->integer()->notNull(),
            'fk_consulta' => $this->integer()->notNull(),
            ], $tableOptions);

        $this->createIndex('i-dudas_user', 'dudas', 'fk_user');
        $this->addForeignKey('dudas_user', 'dudas', 'fk_user','user','id','CASCADE','CASCADE');
        $this->createIndex('i-dudas_consulta', 'dudas', 'fk_consulta');
        $this->addForeignKey('dudas_consulta', 'dudas', 'fk_consulta','consulta','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%dudas}}');
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
