<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CalificarServicioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="calificar-servicio-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ayuda_requerimiento') ?>

    <?= $form->field($model, 'tiempo_respuesta') ?>

    <?= $form->field($model, 'nos_recomendaria') ?>

    <?= $form->field($model, 'ayuda_requerimiento_texto') ?>

    <?php // echo $form->field($model, 'tiempo_respuesta_texto') ?>

    <?php // echo $form->field($model, 'nos_recomendaria_texto') ?>

    <?php // echo $form->field($model, 'fk_consulta') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
