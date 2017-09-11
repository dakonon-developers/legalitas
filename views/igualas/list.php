<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DudasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Planes y Servicios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="planes-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'col-md-4'],
            'itemView' => function ($model, $key, $index, $widget) {
                $imgs = ["/img/empresas_contrara.png","/img/estudiantes_contrata.png","/img/negocios_contrata.png",
                    "/img/abogados_contrata.png","/img/familias_contrata.png", "/img/head_hunter_contrata.png",
                ];
                if($key>5){
                    $key_plus = 5;
                }
                else{
                    $key_plus = ($key-1);
                }
                $html = '<a href="'.Url::to(['/igualas/detail','id'=> $model->id]).'" class="portfolio-box">';
                $html .= '<img src="'.Url::to([$imgs[$key_plus]]).'"" class="img-responsive" alt="'.$model->nombre.'">';
                $html .= '<div class="portfolio-box-caption"><div class="portfolio-box-caption-content">';
                $html .= '<div class="project-name">Planes '.$model->nombre.'</div></div></div></a>';
                /*<div class="project-category text-faded">
                                        Slim, Med y Plus
                                    </div>*/
                $html.= '<br/><br/>';
                return $html;
            },
        ]) ?>
    </div>
</div>
