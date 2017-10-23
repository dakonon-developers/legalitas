<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Igualas */

$this->title = 'Actualizar Iguala: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Igualas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="igualas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-info">Es recomendable sólo actualizar la Iguala si los montos van a sufrir cambios. 
    	Además a cualquier usuario suscrito a la iguala a modificar no se le podrá cobrar el nuevo monto hasta
    	el vencimiento de la iguala. Es decir los cambios en los montos sólo aplican a usuarios nuevos que se suscriban
    	al plan.
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'servicios' => $servicios
    ]) ?>
</div>

<?php
    $this->registerJs(
        "var servicios = ".\yii\helpers\Json::htmlEncode($model->fkServicios).";",
        View::POS_HEAD,'servicios'
    );
    $script = <<< JS
    load_servicios();
JS;

    $this->registerJs($script);
?>
</div>
