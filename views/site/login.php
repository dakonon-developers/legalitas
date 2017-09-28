<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Entrar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login text-center">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-4 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Nombre o Correo') ?>

        <?= $form->field($model, 'password')->passwordInput()->label('Contraseña') ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-3 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ])->label('Recordarme') ?>

        <div class="form-group">
            <div class="col-lg-11">
                <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            <div class="col-lg-11">
                <h5>¿No tienes cuenta?</h5>
                Registrate como <?= Html::a('Usuario', ['site/user-register']) ?> o Registrate como <?= Html::a('Colaborador', ['site/abogado-register']) ?>
            </div>
             <div class="col-lg-11" style="color:#999;margin:1em 0">
                    Si olvidó su contraseña, puede <?= Html::a('restablecerla', ['site/request-password-reset']) ?>.
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
