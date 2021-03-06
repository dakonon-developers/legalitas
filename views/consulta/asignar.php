<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Consulta */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Asignar Abogado';
$this->params['breadcrumbs'][] = ['label' => 'Consultas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="asignacion-form">

	<h1><?= Html::encode($this->title) ?></h1>

    <?= Html::beginForm(['asignar', 'id' => $id], 'post', ['enctype' => 'multipart/form-data']) ?>

    <div class="form-group">
	    <?= Html::dropDownList('Abogados', 0, ArrayHelper::map($abogados,'id',function($abogados){
	    	return $abogados->documento_identidad.' - '.$abogados->nombres.' '.$abogados->apellidos;
	    }),
	    ['prompt'=>'Seleccione un abogado', 'class'=>'form-control','required'=>'true']); ?>
	</div>

    <div class="form-group">
        <?= Html::submitButton('Asignar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php Html::endForm(); ?>

</div>