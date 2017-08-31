<?php

use yii\db\Migration;

class m170724_003051_calificacion extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%calificacion}}',[
            'id' => $this->primaryKey(),
            'fk_consulta' => $this->integer()->notNull(),
            'calificacion' => $this->decimal(10,1)->notNull(),
            'UNIQUE(fk_consulta)',
            ], $tableOptions);

        $this->createIndex('i-calificacion_consulta', 'calificacion', 'fk_consulta');
        $this->addForeignKey('calificacion_consulta', 'calificacion', 'fk_consulta','consulta','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%calificacion}}');
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
