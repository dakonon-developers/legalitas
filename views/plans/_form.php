<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Plans */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plans-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?/*= $form->field($model, 'plan_id')->textInput(['maxlength' => true]) */?> -->

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'precio')->textInput(['onkeyup' => 'render_input_to_cents(this)']) ?>

    <?= $form->field($model, 'intervalo')->dropdownList([
            'month' => 'Mensual',
            'week' => 'Semanal', 
            'year' => 'Anual'
        ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
