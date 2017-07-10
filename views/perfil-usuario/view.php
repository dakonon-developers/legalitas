<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PerfilUsuario */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Perfil Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perfil-usuario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            ['attribute'=>'fkUsuario.username','value'=>$model->fkUsuario->username],
            ['attribute'=>'fkUsuario.email','value'=>$model->fkUsuario->email],
            'nombres',
            'apellidos',
            'documento_identidad',
            //'foto_documento_identidad',
            ['attribute'=>'foto_documento_identidad','value'=> Yii::getAlias('@web') .$model->foto_documento_identidad,
            'format' => ['image',['width'=>'200','height'=>'200','class'=>'img-responsive']],
            ],
            'telefono_oficina',
            'celular',
            'tarjeta_credito',
            }
            ['attribute'=>'activo','value'=>$model->activo ? "Si":"No"],
            ['attribute'=>'fk_nacionalidad','value'=>$model->fkNacionalidad->nombre],
            ['attribute'=>'fk_municipio','value'=>$model->fkMunicipio->nombre],
            //'fk_usuario',
            'categoria',
        ],
    ]) ?>

</div>
