<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */
$primera_lista = [1 => 'Todos', 2 => 'Por Igualas'];

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;

$this->title = 'Enviar Correos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="form-group">

        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

            <?= $form->field($model, 'subject') ?>

            <div class="row">

                <div class="col-md-6">
                    <?= $form->field($model, 'tipo')->dropDownList($primera_lista,
                    ['prompt'=> 'Seleccione el tipo','onclick'=>'llenar_grupo(this.value)']) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'email')->dropDownList($primera_lista,
                    ['prompt'=> 'Seleccione el grupo','disabled'=>True]) ?>
                </div>

            </div>

            <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

            <div class="form-group">
                <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<?php
    $this->registerJs(
        "var igualas = ".\yii\helpers\Json::htmlEncode($igualas).";",
        View::POS_HEAD,'igualas'
    );
    $script = <<< JS
    if($('sendmailsform-tipo').val()!='')
    {
        llenar_grupo($('#sendmailsform-tipo').val());
    }
JS;

    $this->registerJs($script);
?>
</div>
