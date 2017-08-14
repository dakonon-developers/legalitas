<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Promociones */

$this->title = 'Crear Promociones';
$this->params['breadcrumbs'][] = ['label' => 'Promociones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promociones-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
