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
            // 'slim_stripe',
            // 'med_stripe',
            // 'plus_stripe',
        ],
    ]) ?>

    <p>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Deseas eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>