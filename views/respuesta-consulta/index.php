<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;

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
            if((Yii::$app->user->can('Abogado Interno') or Yii::$app->user->can('Abogado Externo')) and !$finalizo){
                echo Html::a('Publicar Respuesta', ['create','consulta'=>$consulta], ['class' => 'btn btn-success']); 
            }
         ?>
    </p>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item row'],
        'itemView' => function ($model, $key, $index, $widget) {
            if($model->fkAbogado->fk_usuario == Yii::$app->user->id){
                $header = '<div class="content"><div class="boxchat-right col-md-11 col-sm-11 col-xs-11">';
                $footer = '</div><div class="boxchat-right_arrow col-md-1 col-sm-1 col-xs-1"></div></div>';
            }
            else{
                $header = '<div class="content"><div class="boxchat-left_arrow col-md-1 col-sm-1 col-xs-1"></div>';
                $header .= '<div class="boxchat-left col-md-11 col-sm-11 col-xs-11">';
                $footer = '</div></div>';
            }
            $html = $header;
            $html .= $model->texto.'<br/>';
            $html .= $model->adjunto.'<br/>';
            $html .= date('d-m-Y H:i:s(a)',strtotime($model->fecha));
            $html .= $footer;
            return $html;
        },
    ]) ?>

    <?php
        if(Yii::$app->user->can('Usuario') and $finalizo){
            echo '<div class="text-center">';
            echo '<button class="btn btn-primary" data-toggle="modal" data-target="#calificar">
            Califica el servicio</button></div>'; 
        }
        else if(!Yii::$app->user->can('Usuario') and !$finalizo){
            echo '<p>Recuerde que una vez publicada la respuesta se dará por cerrada la consulta, si tiene dudas consulte';
            echo 'con el usuario en la sección de dudas antes de publicar en esta sección.</p>';
            echo '<div class="content" style="padding-top:25px;">';
            echo $this->render('_form', [
                    'model' => $model,
                    'consulta' => $consulta,
                ]);
            echo '</div>';
        }
     ?>
</div>

<div class="modal fade" id="calificar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <?php $form = ActiveForm::begin(['action' => ['calificar-servicio/create', 'consulta'=> $consulta] ]); ?>
  
    <div class="modal-dialog"> 
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">
                Califica nuestro servicio
                </h4>
            </div>
            <div class="modal-body">
                
                <h3 class="text-center">Califica nuestro Abogado</h3>
                <?= Html::input('text','star_rating',$calificacion,['class'=>'rating rating-loading', 'data-size'=>'xs']) ?>
            

                <h3 class="text-center">Califica nuestro Servicio</h3>
                <?= $form->field($servicio, 'ayuda_requerimiento')->checkbox([
                    'data-toggle'=>'toggle', 
                    'data-on'=>'Si',
                    'data-off'=> 'No', 
                    'onchange'=>'show_and_require(this,"#ayuda_requerimiento_texto","textarea")'
                ])->label('¿Le ayudamos en su requerimiento?') ?>

                <div id="ayuda_requerimiento_texto" style="display:none;">
                    <?= $form->field($servicio, 'ayuda_requerimiento_texto')->textarea(['rows' => 6])->label('¿Por qué?') ?>
                </div>

                <?= $form->field($servicio, 'tiempo_respuesta')->checkbox([
                    'data-toggle'=>'toggle', 
                    'data-on'=>'Si',
                    'data-off'=> 'No', 
                    'onchange'=>'show_and_require(this,"#tiempo_respuesta_texto","textarea")'
                ])->label('¿El tiempo de respuesta le pareció adecuado?') ?>

                <div id="tiempo_respuesta_texto" style="display:none;">
                    <?= $form->field($servicio, 'tiempo_respuesta_texto')->textarea(['rows' => 6])->label('¿Por qué?') ?>
                </div>

                <?= $form->field($servicio, 'nos_recomendaria')->checkbox([
                    'data-toggle'=>'toggle', 
                    'data-on'=>'Si',
                    'data-off'=> 'No', 
                    'onchange'=>'show_and_require(this,"#nos_recomendaria_texto_no","textarea")'
                ])->label('¿Nos recomendaría?') ?>

                <div id="nos_recomendaria_texto_no" style="display:none;">
                    <?= $form->field($servicio, 'nos_recomendaria_texto')->textarea(['rows' => 6])->label('¿Por qué?') ?>
                </div>

                <div id="nos_recomendaria_texto_si">
                    <h4 class="text-center">¿Díganos a quién? </h4>
                    <?php for($i=1;$i<=3;$i++):?>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <?= Html::activeInput('text',$recomendaciones,'correo[]',['class'=>'form-control','placeholder'=>'correo']) ?>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <?= Html::activeInput('text',$recomendaciones,'telefono[]',['class'=>'form-control','placeholder'=>'telefono']) ?>
                        </div>
                    <?php endfor; ?>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Calificar</button>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>