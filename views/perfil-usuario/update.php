<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PerfilUsuario */

$this->title = 'Actualizar Perfil Usuario: '. $model->nombres . $model->apellidos;
$this->params['breadcrumbs'][] = ['label' => 'Perfil Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="perfil-usuario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_update', [
        'model' => $model,
        'nacionalidad' => $nacionalidad,
        'provincia' => $provincia,
        'municipio' => $municipio,
        'changed_pass' => $changed_pass,
        'plan' => $plan,
        'iguala_user' => $iguala_user,
    ]) ?>

</div>
