<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ConsultaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Actuaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consulta-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            $archivo = $model->archivo ? $model->archivo:'Ningún Archivo Adjunto';
            $abogado = $model->fk_abogado_asignado ? $model->fkAbogadoAsignado->nombres:'Ningún Abogado Asignado';
            $finalizado = $model->finalizado ? "<b class='text-success'>Si</b>":"<b class='text-danger'>No</b>";
            $buttons = '<a class="btn btn-success" href="'.Url::to(['/respuesta-consulta', 'consulta' => $model->id]).'">Respuesta</a>';
            $buttons .= '<a class="btn btn-primary" href="'.Url::to(['/dudas', 'consulta' => $model->id]).'">Dudas</a>';
            $html = '<div class="panel panel-default">';
            $html .= '<div class="panel-heading">';
            $html .= $model->pregunta;
            $html .= ' </div>';
            $html .= '<div class="panel-body">';
            $html .= '<b>Archivo: </b>'.$archivo.'<br/>';
            $html .= '<b>Abogado: </b>'.$abogado.'<br/>';
            $html .= '<b>Finalizado: </b>'.$finalizado.'<br/>';
            $html .= '</div>';
            $html .= '<div class="panel-footer">'. $buttons .'</div>';
            $html .= '</div>';
            return $html;
            //return Html::a(Html::encode($model->id), ['consulta/view', 'id' => $model->id]);
        },
    ]) ?>

</div>
