<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;

$this->title = 'Solicitud de Servicios';
$this->params['breadcrumbs'][] = $this->title;

$template = <<< EOL
<div id="content">
    <div class="row">
       {items}
    </div>
    <div class="text-center">
    	{pager}
    </div>
</div>
EOL;
?>
<div class="site-servicios">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container">

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => $template,
            'itemView' => function ($model, $key, $index, $widget) {
            	$html = '<div class="panel panel-default"><div class="panel-heading">';
				$html .= '<h3 class="panel-title">'.$model->nombre.'</h3></div>';
				$html .= '<div class="panel-body">';
				$html .= '<b>Costo: </b>'.$model->costo.'$<br/>';
				$html .= '<b>Descuento SLIM: </b>'.$model->servicioPromocion->fkPromocion->slim.'%<br/>';
				$html .= '<b>Descuento MED: </b>'.$model->servicioPromocion->fkPromocion->med.'%<br/>';
				$html .= '<b>Descuento PLUS: </b>'.$model->servicioPromocion->fkPromocion->plus.'%';
				$html .= '</div><div class="panel-footer">';
				$html .= Html::a('Solicitar',['consulta/pre-create', 'categoria' => $model->id, 'servicio'=>$model->id], ['class' => 'btn btn-success']);
				$html .= '</div></div>';
                return $html;
            },
        ]) ?>
	</div>
</div>