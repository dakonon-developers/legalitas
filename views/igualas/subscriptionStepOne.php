<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Igualas */

$this->title = 'Planes '.$model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Listado de Igualas', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="igualas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <a href="<?= $approvalUrl ?>">Confirmar la operación</a>

</div>