<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PerfilAbogado */

$this->title = 'Create Perfil Abogado';
$this->params['breadcrumbs'][] = ['label' => 'Perfil Abogados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perfil-abogado-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
