<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ServicioPayments */

$this->title = $model->fkService->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Servicio Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servicio-payments-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'fk_service',
            ['attribute' => 'fk_service', 'value'=>$model->fkService->nombre],
            ['attribute' => 'fk_users_cliente', 'value'=> function($model){
                return $model->fkUsersCliente->nombres ." " .$model->fkUsersCliente->apellidos;
                }
            ],
            //'fk_users_cliente',
            ['attribute' => 'fk_service', 'value'=>$model->fkService->nombre],
            //'fk_payments',
            ['attribute' => 'fkPayments.fecha', 'value'=>date('d-m-Y H:i:s (a)',$model->fkPayments->fecha)],
            ['attribute' => 'fkPayments.monto', 'value'=>$model->fkPayments->monto],
            ['attribute' => 'fkPayments.estatus', 'value'=>$model->fkPayments->estatus],
        ],
    ]) ?>

</div>