<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PagosConfig */

$this->title = 'Create Pagos Config';
$this->params['breadcrumbs'][] = ['label' => 'Pagos Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pagos-config-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
