<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PaypalKey */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Paypal Keys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paypal-key-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'client_id',
            'client_secret',
        ],
    ]) ?>

</div>
