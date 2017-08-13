<?php

use yii\db\Migration;

/**
 * Handles the creation of table `pagos_config`.
 */
class m170804_070516_create_pagos_config_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('pagos_config', [
            'id' => $this->primaryKey(),
            'definicion' => $this->string(),
            'monto' => $this->integer(),
            'intervalo' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('pagos_config');
    }
}
