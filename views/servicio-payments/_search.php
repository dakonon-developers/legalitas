<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ServicioPaymentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="servicio-payments-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="form-group">
        <div class="col-md-6">
            <?= $form->field($model, 'fecha')->widget(\kartik\date\DatePicker::className(),[    
                'options' => ['placeholder' => '-Seleccione la fecha de inicio-'],
                'pluginOptions' => [
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight' => true,
                    'autoclose' => true,

                ]])->label("Fecha Inicio") ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'fecha_fin')->widget(\kartik\date\DatePicker::className(),[    
                'options' => ['placeholder' => '-Seleccione la fecha de fin-'],
                'pluginOptions' => [
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight' => true,
                    'autoclose' => true,

                ]]) ?>
        </div>
    </div>


    <div class="form-group col-md-offset-5">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
