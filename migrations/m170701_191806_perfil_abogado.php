<?php

use yii\db\Migration;

class m170701_191806_perfil_abogado extends Migration
{
   public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%perfil_abogado}}',[
            'id' => $this->primaryKey(),
            'nombres' => $this->string(50)->notNull(),
            'apellidos' => $this->string(50)->notNull(),
            'documento_identidad' => $this->string(14)->notNull(),
            'foto_documento_identidad' => $this->string(128)->notNull(),
            'exequatur' => $this->string(14)->notNull()->unique(),
            'num_carnet' => $this->string(14)->notNull()->unique(),
            'foto_carnet' => $this->string(128)->notNull(),
            'telefono_oficina' => $this->string(10)->notNull(),
            'celular' => $this->string(10)->notNull(),
            'cv_adjunto' => $this->string(128)->notNull(),
            'tipo_abogado' => $this->boolean()->notNull(),  //El tipo de abogado es interno cuando esta true y externo cuando esta false
            'activo' => $this->boolean()->notNull(), 
            'fk_nacionalidad' => $this->integer()->notNull(),
            'fk_municipio' => $this->integer()->notNull(),
            'fk_usuario' => $this->integer()->notNull()->unique(),
            'UNIQUE(id,fk_nacionalidad,fk_municipio)',
            ], $tableOptions);

        $this->createIndex('i-fk_nacionalidad_pa','perfil_abogado','fk_nacionalidad');
        $this->addForeignKey('perfil_abogado_nacionalidad','perfil_abogado','fk_nacionalidad','nacionalidad','id','CASCADE','CASCADE');
        $this->createIndex('i-fk_municipio_pa','perfil_abogado','fk_municipio');
        $this->addForeignKey('perfil_abogado_municipio','perfil_abogado','fk_municipio','municipio','id','CASCADE','CASCADE');
        $this->createIndex('i-fk_usuario_pa','perfil_abogado','fk_usuario');
        $this->addForeignKey('perfil_abogado_user','perfil_abogado','fk_usuario','user','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%perfil_abogado}}');
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
