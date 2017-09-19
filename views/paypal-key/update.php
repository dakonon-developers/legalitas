<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PaypalKey */

$this->title = 'Update Paypal Key: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Paypal Keys', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="paypal-key-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
