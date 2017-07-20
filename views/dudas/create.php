<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Dudas */

$this->title = 'Publicar Duda';
$this->params['breadcrumbs'][] = ['label' => 'Actuaciones', 'url' => ['site/actuaciones']];
$this->params['breadcrumbs'][] = ['label' => 'Dudas', 'url' => ['index', 'consulta' => $consulta ]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dudas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
