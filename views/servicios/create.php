<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Servicios */

$this->title = 'Crear Servicios';
$this->params['breadcrumbs'][] = ['label' => 'Servicios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servicios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'materia' => $materia,
    ]) ?>

</div>
