<?php

use yii\db\Migration;

class m170702_022750_pregunta_especializacion extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%pregunta_especializacion}}',[
            'id' => $this->primaryKey(),
            'fk_pregunta' => $this->integer()->notNull(),
            'fk_especialidad' => $this->integer()->notNull(),
            'UNIQUE(id,fk_pregunta,fk_especialidad)',
            ], $tableOptions);

        $this->createIndex('i-fk_pregunta', 'pregunta_especializacion', 'fk_pregunta');
        $this->addForeignKey('pregunta_especialidad', 'pregunta_especializacion', 'fk_pregunta','preguntas','id','CASCADE','CASCADE');
        $this->createIndex('i-fk_especializacion', 'pregunta_especializacion', 'fk_especialidad');
        $this->addForeignKey('especialidad_pregunta', 'pregunta_especializacion', 'fk_especialidad','especializacion','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%pregunta_especializacion}}');
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
