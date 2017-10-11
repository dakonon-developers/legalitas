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
$miembro_familia = $const['integrante_familia'];

?>
<div class="site-register">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'options' => ['enctype'=>'multipart/form-data']]
    ); ?>

        <div class="form-group">
            <?= $form->errorSummary($model); ?>
        </div>

        <div class="form-group">
            <?= $form->field($model, 'categoria')->dropDownList($categorias,
            ['prompt'=>'Seleccione una categoría','onchange'=>
            'show_content(this,"#register");show_representante(this,"#representante");show_content(this,"#list");show_familia(this,"#familia");']) ?>
        </div>

        <div id="myCarousel" class="carousel slide">
          <!-- Indicators -->
          <div id="register" style="display:none;">
                <div class="carousel-inner">
                    <div class="item active">
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'username')->textInput() ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'email')->textInput() ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'password')->passwordInput() ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'nombres')->textInput() ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'apellidos')->textInput() ?>
                            </div>
                        </div>

                        <div class="row row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'documento_identidad')->textInput()->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999-9999999-9',])  ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'foto_documento_identidad')->fileInput() ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'telefono_oficina')->textInput()->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999999999',])?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'celular')->textInput()->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999999999',])?>
                            </div>
                        </div>

                        <div class="row" id="representante" style="display:none;">
                            <h3 class="text-center">Representante</h3>
                            <div class="col-md-6">
                                <?= $form->field($model, 'nombre_representante')->textInput() ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'documento_identidad_representante')->textInput()->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999-9999999-9',]) ?>
                            </div>
                        </div>

                        <div class="row" id="familia" style="display:none;">
                            <h3 class="text-center">Miembros de la Familia</h3>
                            <div id="miembros_familia">
                                <div class="col-md-6">
                                    <?= $form->field($model, 'miembro')->textInput() ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'tipo')->dropDownList($miembro_familia,['prompt'=>'Seleccione el tipo de miembro']) ?>
                                </div>
                            </div>
                            <div class="text-center">
                                Agregar otro miembro <a onclick="agregar_otro_miembro();" class="green-color-text" style="cursor: pointer">
                                <span class="glyphicon glyphicon-plus"></span></a>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'fk_nacionalidad')->dropDownList(ArrayHelper::map($nacionalidad,'id','nombre'),
                                ['prompt'=> 'Seleccione su nacionalidad','onchange'=>'habilitar_campo(this,"#usuarioform-provincia")']) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'provincia')->dropDownList(ArrayHelper::map($provincia,'id','nombre'),
                                ['prompt'=>'Seleccione la pronvincia','disabled'=>True,
                                'onchange'=>'cargar_municipio(this,"#usuarioform-fk_municipio");habilitar_campo(this,"#usuarioform-fk_municipio");']) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'fk_municipio')->dropDownList(ArrayHelper::map($municipio,'id','nombre'),
                                ['prompt'=>'Seleccione el municipio','disabled'=>True]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="item" style="padding-bottom:20px;">
                        <h3>Cuestionario</h3>
                        <div>
                            <?= $form->field($model, 'servicios')->dropDownList(ArrayHelper::map($especializacion,'id','nombre'),
                                ['multiple'=>True]) ?>
                        </div>
                        <div>
                            <?= $form->field($model, 'otros')->textInput(["data-role"=>"tagsinput"]) ?>
                        </div>
                        <div>
                            <?= $form->field($model, 'demandado')->inline()->radioList([1 => 'Si', 0 => 'No'],
                                ['onchange'=>'radio_value(this,"#cantidad",1);'])
                                ->label("2. ¿Le han demandado o citado a algún tribunal?") ?>
                        </div>
                        <div class="col-md-12" id="cantidad" style="display:none;">
                            <?= $form->field($model, 'cantidad')->textInput()->label('¿Cuántas veces?') ?>
                        </div>
                        <div>
                            <?= $form->field($model, 'consulta_info')->inline()->radioList([1 => 'Si', 0 => 'No'])
                            ->label("3. ¿Desea Recibir Información de Nuestras Actividades?") ?>
                        </div>
                        <div class="row">
                            <div class="text-center">
                                <?= Html::submitButton('Registrarse', ['class' => 'btn btn-primary']) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="left carousel-control green-color-text" href="#myCarousel" onclick="move_carousel('#myCarousel','prev')">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control green-color-text" href="#myCarousel" onclick="move_carousel('#myCarousel','next')">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </div>
            <ol class="carousel-indicators" id="list">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
            </ol>

        </div>

    <?php ActiveForm::end(); ?>

<div class="row" id="familia_form" style="display:none;">
    <div class="row container">
        <div class="col-md-5">
            <?= $form->field($model, 'miembro_extra[]')->textInput() ?>
        </div>
        <div class="col-md-5">
            <?= $form->field($model, 'tipo_extra[]')->dropDownList($miembro_familia,['prompt'=>'Seleccione el tipo de miembro']) ?>
        </div>
        <div class="col-md-2">
            <br/>
            Remover <a onclick="remove_element(this);" class="text-danger" style="cursor: pointer">
            <span class="glyphicon glyphicon-minus"></span></a>
        </div>
    </div>
</div>
<?php
    $this->registerJs(
        "var municipio = ".\yii\helpers\Json::htmlEncode($municipio).";",
        View::POS_HEAD,'municipio'
    );


    $script = <<< JS
    if ($('#usuarioform-categoria').val()!=""){
        $('#register').show();
    }
    if ($('#usuarioform-categoria').val()=="OA" || $('#usuarioform-categoria').val()=="NE"){
        show_representante($('#usuarioform-categoria'),"#representante");
    }
    else if ($('#usuarioform-categoria').val()=="FA"){
        show_familia($('#usuarioform-categoria'),"#familia");
    }
    if($('#usuarioform-fk_nacionalidad').val()!=""){
        $('#usuarioform-provincia').removeAttr('disabled');
    }
    if($('#usuarioform-provincia').val()!=""){
        $('#usuarioform-fk_municipio').removeAttr('disabled');
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

</div>
