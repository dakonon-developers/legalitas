<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pagos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payments-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'charge_id',
            'monto',
            //'fecha',
            ['attribute'=>'fecha','value'=>function($model){
                return date('d-m-Y H:i:s',$model->fecha);
            }],
            //'fk_usuario',
            ['attribute'=>'username','value'=>'fkUsuario.username'],

            ['class' => 'yii\grid\ActionColumn',
            'template'=>'{view}'],
        ],
    ]); ?>

    <div id="grafico"></div>

<?php
    $this->registerJs(
        "var data = ".\yii\helpers\Json::htmlEncode($data).";",
        \yii\web\View::POS_HEAD,'data'
    );
    $this->registerJs(
        "var categorias = ".\yii\helpers\Json::htmlEncode($categorias).";",
        \yii\web\View::POS_HEAD,'categorias'
    );


    $script = <<< JS
    line_graphic("grafico","Registro de Pagos - Legalitas",categorias,"Meses",data);
JS;

    $this->registerJs($script);

?>
</div>
