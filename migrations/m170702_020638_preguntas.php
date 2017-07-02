<?php

use yii\db\Migration;

class m170702_020638_preguntas extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%preguntas}}',[
            'id' => $this->primaryKey(),
            'demandado' => $this->boolean()->notNull(),
            'cantidad' => $this->integer(2)->notNull(),  // Refiere a la cantidad de demandas que ha recibido
            'consulta_info' => $this->boolean()->notNull(), // Define si desea que sea enviado al correo del cliente la informacion de las actividades o en el caso de los abogados verifica si posee experiencia en consultas 
            'fk_user' => $this->integer()->notNull()->unique(),
            ], $tableOptions);
        
        $this->createIndex('i-fk_usuario_pregunta','preguntas','fk_user');
        $this->addForeignKey('preguntas_user','preguntas','fk_user','user','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%preguntas}}');
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
