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

    <div class="container">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item row'],
            'itemView' => function ($model, $key, $index, $widget) {
                if($model->fk_user == Yii::$app->user->id){
                    $header = '<div><div class="boxchat-right col-md-11 col-sm-11 col-xs-11">';
                    $footer = '</div><div class="boxchat-right_arrow col-md-1 col-sm-1 col-xs-1"></div></div>';
                }
                else{
                    $header = '<div><div class="boxchat-left_arrow col-md-1 col-sm-1 col-xs-1"></div>';
                    $header .= '<div class="boxchat-left col-md-11 col-sm-11 col-xs-11">';
                    $footer = '</div></div>';
                }
                $html = $header;
                $html .= $model->texto.'<br/>';
                $html .= $model->adjunto.'<br/>';
                $html .= date('d-m-Y H:i:s(a)',$model->fecha);
                $html .= $footer;
                return $html;
            },
        ]) ?>
    </div>

    <?php if(!$finalizo): ?>
        <div class="content" style="padding-top:25px;">
            <?= $this->render('_form', [
                'model' => $model,
                'consulta' => $consulta,
            ]) ?>
        </div>
    <?php endif; ?>
</div>
