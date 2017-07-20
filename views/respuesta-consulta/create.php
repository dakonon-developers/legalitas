<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RespuestaConsulta */

$this->title = 'Publicar Respuesta';
$this->params['breadcrumbs'][] = ['label' => 'Actuaciones', 'url' => ['site/actuaciones']];
$this->params['breadcrumbs'][] = ['label' => 'Respuesta', 'url' => ['index', 'consulta' => $consulta ]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="respuesta-consulta-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>Recuerde que una vez publicada la respuesta se dará por cerrada la consulta, si tiene dudas consulte
    	con el usuario en la sección de dudas antes de publicar en esta sección.
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
