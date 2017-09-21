<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ConsultaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="consulta-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="form-group">
        <div class="col-md-6">
            <?= $form->field($model, 'creado_en')->widget(\kartik\date\DatePicker::className(),[    
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


    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Resetear', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
