<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PerfilAbogado */

$this->title = 'Actualizar Perfil Abogado: ' . $model->nombres . $model->apellidos;
$this->params['breadcrumbs'][] = ['label' => 'Perfil Abogados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="perfil-abogado-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_update', [
        'model' => $model,
        'nacionalidad' => $nacionalidad,
        'provincia' => $provincia,
        'municipio' => $municipio,
        'changed_pass' => $changed_pass,
    ]) ?>

</div>
