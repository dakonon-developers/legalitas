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

            'id',
            'nombres',
            'apellidos',
            'documento_identidad',
            'foto_documento_identidad',
            // 'exequatur',
            // 'num_carnet',
            // 'telefono_oficina',
            // 'celular',
            // 'cv_adjunto',
            // 'tipo_abogado',
            // 'activo',
            // 'fk_nacionalidad',
            // 'fk_municipio',
            // 'fk_usuario',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
