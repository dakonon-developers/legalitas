<?php

use yii\db\Migration;

class m170919_134957_currency extends Migration
{
    public function up(){

        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%currency}}',[
            'id' => $this->primaryKey(),
            'valor_cambio' => $this->float()->notNull(),
            ], $tableOptions);

        $this->insert('currency', [
            'valor_cambio' => 47.699
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%currency}}');
        echo "Se borro la tabla con exito.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170919_134957_currency cannot be reverted.\n";

        return false;
    }
    */
}
