<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PerfilAbogadoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Perfil Abogados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perfil-abogado-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nombres',
            'apellidos',
            'documento_identidad',
            //'foto_documento_identidad',
            // 'exequatur',
            'num_carnet',
            // 'telefono_oficina',
            // 'celular',
            // 'cv_adjunto',
            //'tipo_abogado',
            ['attribute'=>'tipo_abogado','value'=>function($model){ return $model->tipo_abogado ? "Interno":"Externo";}],
            ['attribute'=>'activo','value'=>function($model){ return $model->activo ? "Si":"No";}],
            // 'activo',
            // 'fk_nacionalidad',
            // 'fk_municipio',
            // 'fk_usuario',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}{activar}',
                'buttons'=> [
                    'activar' => function($url,$model)
                    {
                        return Html::a(
                        '<span class="glyphicon glyphicon-refresh"></span>',
                        ['activar','id'=>$model->id],
                        [
                            'title'=> 'Activar',
                            'data-pjax' => '0',
                            'data' => [
                                'confirm' => '¿Desea activar/desactivar este usuario?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                ],
            ],
        ],
    ]); ?>
</div>
