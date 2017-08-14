<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PagosConfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pagos Configs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pagos-config-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pagos Config', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'definicion',
            'monto',
            'intervalo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
<script>

    var index = 0;
    setTimeout(function(){
        $('table tbody tr td').each(function(){
            var field = this;
            if (index % 3 == 0){
                render_text_to_cents(field)
            }
            index += 1;
        })
    }, 200);
</script>