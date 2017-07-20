<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PerfilUsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Perfil Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perfil-usuario-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            ['attribute'=>'username','value'=>'fkUsuario.username'],
            ['attribute'=>'email','value'=>'fkUsuario.email'],
            'nombres',
            'apellidos',
            'documento_identidad',
            //'foto_documento_identidad',
            // 'telefono_oficina',
            // 'celular',
            // 'tarjeta_credito',
            ['attribute'=>'activo','value'=>function($model){ return $model->activo ? "Si":"No";}],
            // 'fk_nacionalidad',
            // 'fk_municipio',
            // 'fk_usuario',
            // 'categoria',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}{activar}{delete}',
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
