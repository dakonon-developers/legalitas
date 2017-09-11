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
        <?= Html::a('Create Igualas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            //'descripcion:ntext',
            'slim_duracion',
            'med_duracion',
            // 'plus_duracion',
            // 'slim',
            // 'med',
            // 'plus',
            // 'slim_stripe',
            // 'med_stripe',
            // 'plus_stripe',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
