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

    <?php $form = ActiveForm::begin([           
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'options' => ['enctype'=>'multipart/form-data']]
    ); ?>

        <div class="form-group">
            <?= $form->field($model, 'categoria')->dropDownList($categorias,
            ['prompt'=>'Seleccione una categoría','onchange'=>
            'show_content(this,"#register");show_representante(this,"#representante");show_content(this,"#list");']) ?>
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
                                <?= $form->field($model, 'documento_identidad')->textInput() ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'foto_documento_identidad')->fileInput() ?>
                            </div>
                        </div>

                        <div class="row" id="representante" style="display:none;">
                            <div class="col-md-6">
                                <?= $form->field($model, 'nombre_representante')->textInput() ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'documento_identidad_representante')->textInput() ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'telefono_oficina')->textInput() ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'celular')->textInput() ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= $form->field($model, 'tarjeta_credito')->textInput() ?>
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
                    <div class="item">
                        <h3>Cuestionario</h3>
                        <div>
                            <?= $form->field($model, 'servicios')->dropDownList(ArrayHelper::map($especializacion,'id','nombre'),
                                ['multiple'=>True]) ?>
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
                            <div class="col-lg-offset-1 col-lg-11">
                                <?= Html::submitButton('Registrarse', ['class' => 'btn btn-primary']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ol class="carousel-indicators" id="list" style="display:none;">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
            </ol>
            
        </div>

    <?php ActiveForm::end(); ?>
<?php
    $this->registerJs(
        "var municipio = ".\yii\helpers\Json::htmlEncode($municipio).";",
        View::POS_HEAD,'municipio'
    );
?>

</div>