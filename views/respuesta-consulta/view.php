<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RespuestaConsulta */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Respuesta Consultas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="respuesta-consulta-view">

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
            'texto:ntext',
            'adjunto',
            'fecha',
            'fk_abogado',
            'fk_consulta',
        ],
    ]) ?>

</div>
