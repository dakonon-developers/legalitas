<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\IgualasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="igualas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'slim_duracion') ?>

    <?= $form->field($model, 'med_duracion') ?>

    <?php // echo $form->field($model, 'plus_duracion') ?>

    <?php // echo $form->field($model, 'slim') ?>

    <?php // echo $form->field($model, 'med') ?>

    <?php // echo $form->field($model, 'plus') ?>

    <?php // echo $form->field($model, 'slim_stripe') ?>

    <?php // echo $form->field($model, 'med_stripe') ?>

    <?php // echo $form->field($model, 'plus_stripe') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
