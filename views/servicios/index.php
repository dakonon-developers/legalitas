<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ServiciosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Servicios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servicios-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Servicios', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'fkMateria',
            ['attribute'=>'fkMateria','value'=>'fkMateria.nombre'],
            'nombre:ntext',
            //'activo',
            [        
                'attribute' => 'activo',
                'filter'=>array("1"=>"Si","0"=>"No"),
                'value' => function ($model) 
                {
                    return $model->activo ? 'Si' : 'No';
                },
            ],
            'costo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
