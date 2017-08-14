<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Servicios */

$this->title = 'Update Servicios: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Servicios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="servicios-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'materia' => $materia,
    ]) ?>

</div>
