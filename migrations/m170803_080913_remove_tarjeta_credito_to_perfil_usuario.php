<?php

use yii\db\Migration;

class m170803_080913_remove_tarjeta_credito_to_perfil_usuario extends Migration
{
    public function up()
    {
      $this->dropColumn('perfil_usuario', 'tarjeta_credito');
    }

    public function down()
    {
        $this->addColumn('perfil_usuario', 'tarjeta_credito', $this->string());
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
