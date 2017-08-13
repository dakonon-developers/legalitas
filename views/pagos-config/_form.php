<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PagosConfig */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pagos-config-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'definicion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'monto')->textInput(['onkeyup' => 'render_input_to_cents(this)']) ?>

    <?= $form->field($model, 'intervalo')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
