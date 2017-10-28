<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Igualas */

$this->title = 'Pagar servicio';
?>
<div class="igualas-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div><b>Nota:</b> si el usuario ya está subscrito a un plan, es sistema automáticamente lo desuscribirá de ese plan y le asignará este nuevo</div>
    <a href="<?= $approvalUrl ?>">Confirmar la operación</a>

</div>