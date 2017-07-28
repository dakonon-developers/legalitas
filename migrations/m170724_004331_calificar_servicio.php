<?php

use yii\db\Migration;

class m170724_004331_calificar_servicio extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%calificar_servicio}}',[
            'id' => $this->primaryKey(),
            'ayuda_requerimiento' => $this->boolean()->notNull(),
            'tiempo_respuesta' => $this->boolean()->notNull(),
            'nos_recomendaria' => $this->boolean()->notNull(),
            'ayuda_requerimiento_texto' => $this->text(),
            'tiempo_respuesta_texto' => $this->text(),
            'nos_recomendaria_texto' => $this->text(),
            'fk_consulta' => $this->integer()->unique(),
            ], $tableOptions);

        $this->createIndex('i-calificar_servicio', 'calificar_servicio', 'fk_consulta');
        $this->addForeignKey('calificar_servicio', 'calificar_servicio', 'fk_consulta','consulta','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%calificar_servicio}}');
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
