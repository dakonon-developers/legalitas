<?php

use yii\db\Migration;

class m170724_004843_recomendaciones extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%recomendaciones}}',[
            'id' => $this->primaryKey(),
            'fk_calificacion_servicio' => $this->integer()->notNull(),
            'correo' => $this->string()->notNull(),
            'telefono' => $this->string()->notNull(),
            ], $tableOptions);

        $this->createIndex('i-recomendacion_calificar_servicio', 'recomendaciones', 'fk_calificacion_servicio');
        $this->addForeignKey('recomendacion_calificar_servicio', 'recomendaciones', 'fk_calificacion_servicio','calificar_servicio','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%recomendaciones}}');
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
