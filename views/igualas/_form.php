<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Igualas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="igualas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?php //$form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'slim_duracion')->textInput() ?>

    <?= $form->field($model, 'med_duracion')->textInput() ?>

    <?= $form->field($model, 'plus_duracion')->textInput() ?>

    <?= $form->field($model, 'slim')->textInput(['onkeyup' => 'render_input_to_cents(this)']) ?>

    <?= $form->field($model, 'med')->textInput(['onkeyup' => 'render_input_to_cents(this)']) ?>

    <?= $form->field($model, 'plus')->textInput(['onkeyup' => 'render_input_to_cents(this)']) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
