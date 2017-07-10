<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PerfilUsuarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="perfil-usuario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nombres') ?>

    <?= $form->field($model, 'apellidos') ?>

    <?= $form->field($model, 'documento_identidad') ?>

    <?= $form->field($model, 'foto_documento_identidad') ?>

    <?php // echo $form->field($model, 'telefono_oficina') ?>

    <?php // echo $form->field($model, 'celular') ?>

    <?php // echo $form->field($model, 'tarjeta_credito') ?>

    <?php // echo $form->field($model, 'activo') ?>

    <?php // echo $form->field($model, 'fk_nacionalidad') ?>

    <?php // echo $form->field($model, 'fk_municipio') ?>

    <?php // echo $form->field($model, 'fk_usuario') ?>

    <?php // echo $form->field($model, 'categoria') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
