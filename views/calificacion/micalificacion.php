<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CalificacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mis Calificaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calificacion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'fkConsulta.pregunta',
            //'fkAbogadoAsignado',
            //'calificacion',
            ['attribute'=>'calificacion','format'=>'raw','value'=> function($model){
                return (
                    Html::input('text','star_rating',$model->calificacion,[
                        'class'=>'rating rating-loading', 
                        'data-size'=>'xs',
                        'data-display-only'=>"true",
                        ])
                );
            }],

            ['class' => 'yii\grid\ActionColumn',
            'template'=>''],
        ],
    ]); ?>
</div>