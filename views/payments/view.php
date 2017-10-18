<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Payments */

$this->title = date('d-m-Y H:i:s (a)',$model->fecha);
$this->params['breadcrumbs'][] = ['label' => 'Pagos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payments-view">

    <h1>Pago Realizado el <?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'charge_id',
            'monto',
            //'fecha',
            ['attribute' => 'fecha', 'value'=> date('d-m-Y H:i:s (a)',$model->fecha)],
            ['attribute' => 'fk_usuario', 'value'=>$model->fkUsuario->username],
        ],
    ]) ?>

</div>
