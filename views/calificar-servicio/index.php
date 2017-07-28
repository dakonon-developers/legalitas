<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CalificarServicioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Calificar Servicios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calificar-servicio-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Calificar Servicio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ayuda_requerimiento',
            'tiempo_respuesta',
            'nos_recomendaria',
            'ayuda_requerimiento_texto:ntext',
            // 'tiempo_respuesta_texto:ntext',
            // 'nos_recomendaria_texto:ntext',
            // 'fk_consulta',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
