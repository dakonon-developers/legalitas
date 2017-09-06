<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `stripe_to_igualas`.
 */
class m170826_004307_drop_stripe_to_igualas_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        // Drop stripe's columns
        // $this->dropColumn('igualas', 'slim_stripe');
        // $this->dropColumn('igualas', 'med_stripe');
        // $this->dropColumn('igualas', 'plus_stripe');
        // add tipo column
        // $this->addColumn('igualas', 'tipo', $this->string(25)->notNull());
        // alter column nombre (quit unique)
        // $this->alterColumn('igualas', 'nombre', $this->string(25)->notNull());

        $this->addColumn('igualas', 'slim_paypal_id', $this->string()->unique());
        $this->addColumn('igualas', 'med_paypal_id', $this->string()->unique());
        $this->addColumn('igualas', 'plus_paypal_id', $this->string()->unique());

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // Add stripe's columns
        // $this->addColumn('igualas', 'slim_stripe', $this->string(25)->notNull()->unique());
        // $this->addColumn('igualas', 'med_stripe', $this->string(25)->notNull()->unique());
        // $this->addColumn('igualas', 'plus_stripe', $this->string(25)->notNull()->unique());
        $this->dropColumn('igualas', 'slim_paypal_id');
        $this->dropColumn('igualas', 'med_paypal_id');
        $this->dropColumn('igualas', 'plus_paypal_id');
        // drop tipo to igualas
        // $this->dropColumn('igualas', 'tipo');
        // alter column nombre (add unique)
        // $this->alterColumn('igualas', 'nombre', $this->string(25)->notNull());

    }
}
