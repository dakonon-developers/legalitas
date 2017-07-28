<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CalificarServicio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="calificar-servicio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ayuda_requerimiento')->textInput() ?>

    <?= $form->field($model, 'tiempo_respuesta')->textInput() ?>

    <?= $form->field($model, 'nos_recomendaria')->textInput() ?>

    <?= $form->field($model, 'ayuda_requerimiento_texto')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tiempo_respuesta_texto')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'nos_recomendaria_texto')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fk_consulta')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
