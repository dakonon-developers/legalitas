<?php

use yii\db\Migration;

class m170813_001804_igualas extends Migration
{
    public function up()
    {
        $tableOptions =null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%igualas}}',[
            'id' => $this->primaryKey(),
            'nombre' => $this->string(255)->notNull(),
            // 'descripcion' => $this->text(),
            'slim_duracion' => $this->integer()->notNull()->defaultValue(3),
            'med_duracion' => $this->integer()->notNull()->defaultValue(7),
            'plus_duracion' => $this->integer()->notNull()->defaultValue(10),
            'slim' => $this->float()->notNull(),
            'med' => $this->float()->notNull(),
            'plus' => $this->float()->notNull(),
            // 'slim_stripe' => $this->string(25)->notNull()->unique(),
            // 'med_stripe' => $this->string(25)->notNull()->unique(),
            // 'plus_stripe' => $this->string(25)->notNull()->unique(),
            // 'tipo' => $this->string(25)->notNull(),
            ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%igualas}}');
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
