<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DudasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dudas';
$this->params['breadcrumbs'][] = ['label' => 'Actuaciones', 'url' => ['site/actuaciones']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dudas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Publicar una Duda', ['create','consulta'=>$consulta], ['class' => 'btn btn-success']) ?>
    </p>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            if($model->fk_user == Yii::$app->user->id){
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
</div>
