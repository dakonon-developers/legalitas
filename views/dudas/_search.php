<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DudasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dudas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'texto') ?>

    <?= $form->field($model, 'adjunto') ?>

    <?= $form->field($model, 'leido') ?>

    <?= $form->field($model, 'fecha') ?>

    <?php // echo $form->field($model, 'fk_user') ?>

    <?php // echo $form->field($model, 'fk_consulta') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
