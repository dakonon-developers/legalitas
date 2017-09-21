<?php

use yii\db\Migration;

class m170701_191758_perfil_usuario extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%perfil_usuario}}',[
            'id' => $this->primaryKey(),
            'nombres' => $this->string(50)->notNull(),
            'apellidos' => $this->string(50)->notNull(),
            'documento_identidad' => $this->string(14)->notNull(),
            'foto_documento_identidad' => $this->string(128)->notNull(),
            'telefono_oficina' => $this->string(10)->notNull(),
            'celular' => $this->string(10)->notNull(),
            'activo' => $this->boolean()->notNull(), 
            'fk_nacionalidad' => $this->integer()->notNull(),
            'fk_municipio' => $this->integer()->notNull(),
            'fk_usuario' => $this->integer()->notNull()->unique(),
            'categoria' => $this->string(2)->notNull(),
            ], $tableOptions);

        $this->createIndex('i-fk_nacionalidad','perfil_usuario','fk_nacionalidad');
        $this->addForeignKey('perfil_usuario_nacionalidad','perfil_usuario','fk_nacionalidad','nacionalidad','id','CASCADE','CASCADE');
        $this->createIndex('i-fk_municipio','perfil_usuario','fk_municipio');
        $this->addForeignKey('perfil_usuario_municipio','perfil_usuario','fk_municipio','municipio','id','CASCADE','CASCADE');
        $this->createIndex('i-fk_usuario','perfil_usuario','fk_usuario');
        $this->addForeignKey('perfil_usuario_user','perfil_usuario','fk_usuario','user','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%perfil_usuario}}');
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
