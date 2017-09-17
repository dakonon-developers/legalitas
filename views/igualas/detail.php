<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Igualas */

$this->title = 'Planes '.$model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Listado de Igualas', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="igualas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th></th>
                    <th>Slim</th>
                    <th>Med</th>
                    <th>Plus</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Duración</td>
                    <td><b><?= $model->slim_duracion ?></b> veces al mes</td>
                    <td><b><?= $model->med_duracion ?></b> veces al mes</td>
                    <td><b><?= $model->plus_duracion ?></b> veces al mes</td>
                </tr>
                <tr>
                    <td>Costo</td>
                    <td><?= $model->slim ?>$ al mes</td>
                    <td><?= $model->med ?>$ al mes</td>
                    <td><?= $model->plus ?>$ al mes</td>
                </tr>
                <tr>
                    <td>Suscribirse</td>
                    <td><?= Html::a('Suscribirse', ['subscribe', 'id' => $model->id, 'plan' => $model->slim_paypal_id], ['class' => 'btn btn-primary']) ?></td>
                    <td><?= Html::a('Suscribirse', ['subscribe', 'id' => $model->id, 'plan' => $model->med_paypal_id], ['class' => 'btn btn-primary']) ?></td>
                    <td><?= Html::a('Suscribirse', ['subscribe', 'id' => $model->id, 'plan' => $model->plus_paypal_id], ['class' => 'btn btn-primary']) ?></td>
                </tr>
            </tbody>
        </table>
    </div>

</div>