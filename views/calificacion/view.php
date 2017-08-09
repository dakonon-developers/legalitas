<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Calificacion */

$this->title = $model->fkConsulta->pregunta;
$this->params['breadcrumbs'][] = ['label' => 'Calificaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calificacion-view">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1><br/>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'fk_consulta',
            ['attribute'=>'calificacion','format'=>'raw','value'=>
                Html::input('text','star_rating',$model->calificacion,[
                    'class'=>'rating rating-loading', 
                    'data-size'=>'xs',
                    'data-display-only'=>"true",
                ])
            ],
            ['attribute'=>'fkConsulta.fkAbogadoAsignado.documento_identidad'],
            ['attribute'=>'fkConsulta.fkAbogadoAsignado.nombres',
            'value'=> $model->fkConsulta->fkAbogadoAsignado->nombres.' '.$model->fkConsulta->fkAbogadoAsignado->apellidos ],
            ['attribute'=>'fkConsulta.fkCliente.documento_identidad'],
            ['attribute'=>'fkConsulta.fkCliente.nombres',
            'value'=> $model->fkConsulta->fkCliente->nombres.' '.$model->fkConsulta->fkCliente->apellidos ],
            ['attribute'=>'fkConsulta.fkServicio.nombre'],
            ['attribute'=>'fkConsulta.calificarServicio.ayuda_requerimiento','value'=>$model->fkConsulta->calificarServicio->ayuda_requerimiento ? "Si":"No"],
            ['attribute'=>'fkConsulta.calificarServicio.ayuda_requerimiento_texto'],
            ['attribute'=>'fkConsulta.calificarServicio.tiempo_respuesta','value'=>$model->fkConsulta->calificarServicio->tiempo_respuesta ? "Si":"No"],
            ['attribute'=>'fkConsulta.calificarServicio.tiempo_respuesta_texto'],
            ['attribute'=>'fkConsulta.calificarServicio.nos_recomendaria','value'=>$model->fkConsulta->calificarServicio->nos_recomendaria ? "Si":"No"],
            ['attribute'=>'fkConsulta.calificarServicio.nos_recomendaria_texto'],
        ],
    ]) ?>

    <?php
        if($recomendaciones){
            echo '<div class="table-responsive"><table class="table table-striped">';
            echo '<caption class="text-center"><h3>Recomendaciones</h3></caption><thead>';
            echo '<tr><th>Correo</th><th>Télefono</th></tr>';
            echo '</thead>';
            foreach ($recomendaciones as $key => $value) {
                echo '<tr><td>'.$value->correo.'</td>';
                echo '<td>'.$value->telefono.'</td></tr>';
            }
            echo '</table></div>';
        }
    ?>

</div>
