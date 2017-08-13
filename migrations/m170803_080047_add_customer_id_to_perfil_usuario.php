<?php

use yii\db\Migration;

class m170803_080047_add_customer_id_to_perfil_usuario extends Migration
{
    public function up()
    {
      $this->addColumn('perfil_usuario', 'customer_id', $this->string());
    }

    public function down()
    {
      $this->dropColumn('perfil_usuario', 'customer_id');
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
