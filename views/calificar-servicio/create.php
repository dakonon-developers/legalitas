<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CalificarServicio */

$this->title = 'Create Calificar Servicio';
$this->params['breadcrumbs'][] = ['label' => 'Calificar Servicios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calificar-servicio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
