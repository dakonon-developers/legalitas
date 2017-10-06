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
            //$abogado = $model->fk_abogado_asignado ? $model->fkAbogadoAsignado->nombres:'Ningún Abogado Asignado';
            $archivo = $model->archivo ? $model->archivo:'Ningún Archivo Adjunto';
            $finalizado = $model->finalizado ? "<b class='text-success'>Si</b>":"<b class='text-danger'>No</b>";
            $color = '';
            if(!$model->finalizado){
                $color = $model->fk_abogado_asignado ? "warning-text":"danger-text";
            }
            else{
                $color = "green-color-text";
            }
            $respuestas = $model->finalizado ? "Existe una respuesta para esta consulta":"No se han publicado respuestas";
            $respuesta_enlace = '<a href="'.Url::to(['/respuesta-consulta', 'consulta' => $model->id]).'">Ver</a>';
            $dudas_enlace = '<a href="'.Url::to(['/dudas', 'consulta' => $model->id]).'">Ver</a>'; 
            $cantidad_dudas = count($model->getDudas()->all());
            $cantidad_adjuntos_dudas = count($model->getDudas()->where("adjunto != '' ")->all());
            $html = '<ul class="list-group '.$color.'"><li class="list-group-item">';
            $html .= '<a data-toggle="collapse" href="#opciones'.$key.'"><span class="glyphicon glyphicon-folder-open"></span></a> '.$model->pregunta;
            $html_respuesta = '<ul class="panel-collapse collapse" id="opciones'.$key.'"><li class="not_decoration">';
            $html_respuesta .= '<a data-toggle="collapse" href="#respuestas_'.$key.'"><span class="glyphicon glyphicon-plus"></span></a> Respuestas';
            $html_respuesta .= '</li><ul class="panel-collapse collapse" id="respuestas_'.$key.'"><li class="not_decoration">'.$respuestas.'</li>';
            $html_respuesta .= '<li class="not_decoration">'.$archivo.'</li>';
            $html_respuesta .= '<li class="not_decoration">'.$respuesta_enlace.'</li></ul>';
            $html_dudas = '<li class="not_decoration"><a data-toggle="collapse" href="#dudas_'.$key.'"><span class="glyphicon glyphicon-plus"></span></a> Dudas';
            $html_dudas .= '</li><ul class="panel-collapse collapse" id="dudas_'.$key.'"><li class="not_decoration">Se han publicado '.$cantidad_dudas.' dudas</li>';
            $html_dudas .= '<li class="not_decoration">Existen '.$cantidad_adjuntos_dudas.' archivos adjuntos</li>';
            $html_dudas .= '<li class="not_decoration">'.$dudas_enlace.'</li></ul>';
            $html .= $html_respuesta;
            $html .= $html_dudas;
            $html .= '</ul></li></ul>';
            /*$buttons = '<a class="btn btn-success" href="'.Url::to(['/respuesta-consulta', 'consulta' => $model->id]).'">Respuesta</a>';
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
            $html .= '</div>';*/
            return $html;
        },
    ]) ?>

</div>
