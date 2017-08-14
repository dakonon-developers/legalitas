<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Servicios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="servicios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fk_materia')->dropDownList(ArrayHelper::map($materia,'id','nombre'),
        ['prompt'=> 'Seleccione la materia']) ?>

    <?= $form->field($model, 'activo')->checkBox(['data-toggle'=>'toggle', 'data-on'=>'Si','data-off'=> 'No']) ?>

    <?= $form->field($model, 'costo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
