<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

$this->title = 'Solicitud de Servicios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-servicios">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['id' => 'servicios-form']); ?>

        <?= $form->field($model, 'servicios')->dropDownList(ArrayHelper::map($servicios,'id','nombre'),
        ['prompt'=> 'Seleccione el servicio']) ?>

        <div class="form-group">
            <?= Html::submitButton('Solicitar', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
