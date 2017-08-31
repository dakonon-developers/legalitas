<?php

use yii\db\Migration;

/**
 * Handles the creation of table `plans`.
 */
class m170827_201203_create_plans_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {

        $this->createTable('plans', [
            'id' => $this->primaryKey(),
            'plan_id' => $this->string(),
            'nombre' => $this->string(),
            'descripcion' => $this->string(),
            'precio' => $this->string(),
            'intervalo' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('plans');
    }
}
