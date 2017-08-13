<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Promociones */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promociones-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'slim')->textInput() ?>

    <?= $form->field($model, 'med')->textInput() ?>

    <?= $form->field($model, 'plus')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
