<?php

use yii\db\Migration;

class m171010_171847_familia extends Migration
{
   public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%familia}}',[
            'id' => $this->primaryKey(),
            'miembro' => $this->string(100)->notNull(),
            'tipo' => $this->string(2)->notNull(),
            'fk_perfil_usuario' => $this->integer()->notNull()->unique(),
            ], $tableOptions);
        
        $this->createIndex('i-fk_usuario_familia','familia','fk_perfil_usuario');
        $this->addForeignKey('familia_usuario','familia','fk_perfil_usuario','perfil_usuario','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%familia}}');
        echo "Se borro la tabla con exito.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171010_171847_familia cannot be reverted.\n";

        return false;
    }
    */
}
