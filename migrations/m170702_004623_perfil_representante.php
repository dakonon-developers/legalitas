<?php

use yii\db\Migration;

class m170702_004623_perfil_representante extends Migration
{
   public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%perfil_representante}}',[
            'id' => $this->primaryKey(),
            'nombre_representante' => $this->string(50)->notNull(),
            'documento_identidad_represetntante' => $this->string(14)->notNull(),
            'fk_perfil_usuario' => $this->integer()->notNull()->unique(),
            ], $tableOptions);
        
        $this->createIndex('i-fk_usuario_pr','perfil_representante','fk_perfil_usuario');
        $this->addForeignKey('perfil_representante_user','perfil_representante','fk_perfil_usuario','perfil_usuario','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%perfil_representante}}');
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
