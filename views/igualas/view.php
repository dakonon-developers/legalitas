<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Igualas */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Igualas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="igualas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'nombre',
            //'descripcion:ntext',
            'slim_duracion',
            'med_duracion',
            'plus_duracion',
            'slim',
            'med',
            'plus',
            ['attribute' => 'estado','value'=>$model->estado ? "Activa":"Inactiva"]
            // 'slim_stripe',
            // 'med_stripe',
            // 'plus_stripe',
        ],
    ]) ?>

    <h3 class="text-center">Servicios asignados</h3>
    <ul>
        <?php 
            foreach ($model->igualasServicios as $key => $value) {
                echo '<li>'.$value->fkServicio->nombre.'</li>';
            }
        ?>
    </ul>

    <div class="alert alert-danger">Si eliminas esta iguala, a los usuarios que esten inscritos se les seguira cobrando hasta el vencimiento
        de la misma.
    </div>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], [
            'class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Deseas eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>