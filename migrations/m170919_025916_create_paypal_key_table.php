<?php

use yii\db\Migration;

/**
 * Handles the creation of table `paypal_key`.
 */
class m170919_025916_create_paypal_key_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('paypal_key', [
            'id' => $this->primaryKey(),
            'client_id' => $this->string(),
            'client_secret' => $this->string(),
        ]);
        $this->insert('paypal_key', [
            'client_id' => 'Id del cliente de PayPal',
            'client_secret' => 'Clave secreta de PayPal',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('paypal_key');
    }
}
