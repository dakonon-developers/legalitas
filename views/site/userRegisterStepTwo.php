<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\web\View;

$const = require(__DIR__ . '/../../config/constants.php');

$this->title = 'Registrarse - Usuario';
$this->params['breadcrumbs'][] = $this->title;

$categorias = $const['categories'];

?>
<div class="site-register">
    <h1><?= Html::encode($this->title) ?></h1>

    <h3>Para concretar el pago dirigase al siguiente link:</h3>
    <a href="<?= $charge->approval_link ?>">Confirmar la operación</a>
</div>
