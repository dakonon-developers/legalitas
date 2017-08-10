<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Consulta */

$this->title = $model->id;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consulta-view">

    <h1><?= Html::encode($model->pregunta) ?></h1>

     <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'fk_cliente',
            'fk_servicio',
            'fk_abogado_asignado',
            'pregunta:ntext',
            'archivo',
            ['attribute'=>'finalizado','value'=>$model->finalizado ? "Si":"No"],
            //'creado_en',
            ['attribute'=>'creado_en','value'=> date('d-m-Y H:i:s',$model->creado_en) ],
            'fecha_fin',
        ],
    ]) ?>

</div>
