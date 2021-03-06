<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dudas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dudas-form">

    <?php $form = ActiveForm::begin(['action'=>['dudas/create','consulta'=>$consulta]]); ?>

    <?= $form->field($model, 'texto')->textarea(['rows' => 6])->label(false) ?>

    <?= $form->field($model, 'adjunto')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Publicar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
