<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PerfilAbogado */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="perfil-abogado-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'documento_identidad')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'foto_documento_identidad')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'exequatur')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num_carnet')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefono_oficina')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'celular')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cv_adjunto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo_abogado')->textInput() ?>

    <?= $form->field($model, 'activo')->textInput() ?>

    <?= $form->field($model, 'fk_nacionalidad')->textInput() ?>

    <?= $form->field($model, 'fk_municipio')->textInput() ?>

    <?= $form->field($model, 'fk_usuario')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
