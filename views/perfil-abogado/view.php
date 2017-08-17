<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PerfilAbogado */

$this->title = $model->nombres.' '.$model->apellidos;
$this->params['breadcrumbs'][] = ['label' => 'Perfil Abogados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perfil-abogado-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'nombres',
            'apellidos',
            'documento_identidad',
            'foto_documento_identidad',
            'exequatur',
            'num_carnet',
            'telefono_oficina',
            'celular',
            'cv_adjunto',
            //'tipo_abogado',
            ['attribute'=>'tipo_abogado','value'=>$model->tipo_abogado ? "Externo":"Interno"],
            ['attribute'=>'activo','value'=>$model->activo ? "Si":"No"],
            ['attribute'=>'fk_nacionalidad','value'=>$model->fkNacionalidad->nombre],
            ['attribute'=>'fk_municipio','value'=>$model->fkMunicipio->nombre],
            //'fk_usuario',
        ],
    ]) ?>

</div>
