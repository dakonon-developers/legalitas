<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\PerfilAbogado */
/* @var $form yii\widgets\ActiveForm */
$const = require(__DIR__ . '/../../config/constants.php');

$this->title = 'Registrarse - Usuario';
$this->params['breadcrumbs'][] = $this->title;

$categorias = $const['categories'];
?>

<div class="perfil-abogado-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'nombres')->textInput() ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'apellidos')->textInput() ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'documento_identidad')->textInput()->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999-9999999-9',])  ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'foto_documento_identidad')->fileInput() ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'telefono_oficina')->textInput()->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999999999',]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'celular')->textInput()->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999999999',] ) ?>
                    </div>
                </div>

                    <div class="row">
                        <div class="col-md-6">
                                <?= $form->field($model, 'activo')->checkbox(['data-toggle'=>'toggle', 'data-on'=>'Si','data-off'=> 'No', ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'fk_nacionalidad')->dropDownList(ArrayHelper::map($nacionalidad,'id','nombre'),
                            ['prompt'=> 'Seleccione su nacionalidad','onchange'=>'habilitar_campo(this,"#abogadoform-provincia")']) ?>
                        </div>
                        <div class="col-md-4">
                            <label>Provincia</label>
                            <?= Html::dropDownList('provincia','',ArrayHelper::map($provincia, 'id', 'nombre'), 
                             ['prompt'=>'Seleccione la provincia','class'=>'form-control','id'=>'provincia', 'onchange'=>'cargar_municipio(this,"#perfilusuario-fk_municipio");habilitar_campo(this,"#perfilusuario-fk_municipio");']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'fk_municipio')->dropDownList(ArrayHelper::map($municipio,'id','nombre'),
                            ['prompt'=>'Seleccione el municipio','disabled'=>True]) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'categoria')->dropDownList($categorias,
                        ['prompt'=>'Seleccione una categoría']) ?>
                    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<div class="panel-group">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" class="glyphicon glyphicon-chevron-right" href="#cambiar"> Cambiar Contraseña</a>
      </h4>
    </div>
    <div id="cambiar" class="panel-collapse collapse">
      <ul class="list-group">
        <li class="list-group-item">
          <?php $form = ActiveForm::begin([
          'action' => ['perfil-usuario/change-password', 'id'=> Yii::$app->user->id],
          'method' => 'post',
          ]); ?>
            <?= $form->field($changed_pass, 'old_password')->passwordInput() ?>
            <?= $form->field($changed_pass, 'password')->passwordInput() ?>
            <?= $form->field($changed_pass, 'confirm_password')->passwordInput() ?>
     
            <div class="form-group">
                <?= Html::submitButton('Cambiar', ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>
        </li>
      </ul>
    </div>
  </div>
</div>
    

</div>
<?php
    $this->registerJs(
        "var municipio = ".\yii\helpers\Json::htmlEncode($municipio).";",
        View::POS_HEAD,'municipio'
    );
    $script = <<< JS
    if($('#provincia').val()!=""){
        $('#perfilusuario-fk_municipio').removeAttr('disabled');
    }
    $('form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
            e.preventDefault();
            return false;
        }
    });
JS;

    $this->registerJs($script);
?>