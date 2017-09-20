<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IgualasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Igualas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="igualas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Igualas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nombre',
            //'descripcion:ntext',
            ['attribute' => 'slim','value'=>function($model){return $model->slim.' $';}],
            'slim_duracion',
            ['attribute' => 'med','value'=>function($model){return $model->med.' $';}],
            'med_duracion',
            ['attribute' => 'plus','value'=>function($model){return $model->plus.' $';}],
            'plus_duracion',
            // 'slim_stripe',
            // 'med_stripe',
            // 'plus_stripe',

            ['class' => 'yii\grid\ActionColumn','template'=>'{view}{update}'],
        ],
    ]); ?>
</div>
