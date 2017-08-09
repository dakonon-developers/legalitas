<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PerfilAbogado */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Perfil Abogados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perfil-abogado-view">

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
            'id',
            'nombres',
            'apellidos',
            'documento_identidad',
            'foto_documento_identidad',
            'exequatur',
            'num_carnet',
            'telefono_oficina',
            'celular',
            'cv_adjunto',
            'tipo_abogado',
            'activo',
            'fk_nacionalidad',
            'fk_municipio',
            'fk_usuario',
        ],
    ]) ?>

</div>
