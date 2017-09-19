<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PaypalKey */

$this->title = 'Create Paypal Key';
$this->params['breadcrumbs'][] = ['label' => 'Paypal Keys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paypal-key-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
