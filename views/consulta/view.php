<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Consulta */

$this->title = $model->id;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consulta-view">

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
            'fk_cliente',
            'fk_servicio',
            'fk_abogado_asignado',
            'pregunta:ntext',
            'imagen',
            'finalizado',
            'creado_en',
            'fecha_fin',
        ],
    ]) ?>

</div>
