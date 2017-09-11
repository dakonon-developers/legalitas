<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Igualas */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Igualas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="igualas-view">

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
            'nombre',
            //'descripcion:ntext',
            'slim_duracion',
            'med_duracion',
            'plus_duracion',
            'slim',
            'med',
            'plus',
            'slim_stripe',
            'med_stripe',
            'plus_stripe',
        ],
    ]) ?>

</div>
<script>

    var index = 0;
    setTimeout(function(){
        $('table tbody tr td').each(function(){
            var field = this;
            if (index >= 6 && index <= 8 ){
                console.log("index", index)
                console.log(field.textContent)
                render_text_to_cents(field)
            }
            index += 1;
        })
    }, 200);
</script>