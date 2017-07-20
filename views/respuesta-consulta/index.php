<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RespuestaConsultaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Respuesta';
$this->params['breadcrumbs'][] = ['label' => 'Actuaciones', 'url' => ['site/actuaciones']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="respuesta-consulta-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
            if(Yii::$app->user->can('Abogado Interno') or Yii::$app->user->can('Abogado Externo')){
                echo Html::a('Publicar Respuesta', ['create','consulta'=>$consulta], ['class' => 'btn btn-success']); 
            }
         ?>
    </p>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            if($model->fkAbogado->fk_usuario == Yii::$app->user->id){
                $header = '<div class="content"><div class="boxchat-right col-md-11">';
                $footer = '</div><div class="boxchat-right_arrow col-md-1"></div></div>';
            }
            else{
                $header = '<div class="content"><div class="boxchat-left_arrow col-md-1"></div>';
                $header .= '<div class="boxchat-left col-md-11">';
                $footer = '</div></div>';
            }
            $html = $header;
            $html .= $model->texto.'<br/>';
            $html .= $model->adjunto.'<br/>';
            $html .= date('d-m-Y H:i:s(a)',strtotime($model->fecha));
            $html .= $footer;
            return $html;
            //return Html::a(Html::encode($model->id), ['view', 'id' => $model->id]);
        },
    ]) ?>

    <?php
        if(Yii::$app->user->can('Usuario')){
            echo '<div class="text-center">';
            echo '<button class="btn btn-primary">Califica al abogado</button></div>'; 
        }
     ?>
</div>
