<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Igualas */

$this->title = 'Crear Igualas';
$this->params['breadcrumbs'][] = ['label' => 'Igualas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="igualas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
