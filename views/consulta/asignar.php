<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Consulta */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Asignar Abogado';
$this->params['breadcrumbs'][] = ['label' => 'Consultas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="asignacion-form">

	<h1><?= Html::encode($this->title) ?></h1>

    <?= Html::beginForm(['aisgnar', 'id' => $id], 'post', ['enctype' => 'multipart/form-data']) ?>

    <?= Html::dropDownList('Abogados', 0, []); ?>

    <div class="form-group">
        <?= Html::submitButton('Asignar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php Html::endForm(); ?>

</div>