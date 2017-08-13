<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Igualas */

$this->title = 'Update Igualas: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Igualas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="igualas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
