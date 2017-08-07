<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CalificarServicio */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Calificar Servicios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calificar-servicio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ayuda_requerimiento',
            'tiempo_respuesta',
            'nos_recomendaria',
            'ayuda_requerimiento_texto:ntext',
            'tiempo_respuesta_texto:ntext',
            'nos_recomendaria_texto:ntext',
            'fk_consulta',
        ],
    ]) ?>

</div>
