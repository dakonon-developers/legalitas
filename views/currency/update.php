<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Currency */

$this->title = 'Actualizar Tasa de Cambio: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tasa de Cambio', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="currency-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
