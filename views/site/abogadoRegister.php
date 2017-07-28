<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;

$this->title = 'Registrar - Abogado';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-register">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
    <div id="myCarousel" class="carousel slide">
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

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'documento_identidad')->textInput()->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '999-9999999-9',])  ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'foto_documento_identidad')->fileInput() ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'exequatur')->textInput() ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'num_carnet')->textInput() ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'foto_carnet')->fileInput() ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'telefono_oficina')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '9999999999',]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'celular')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '9999999999',] )?>
                    </div>
                </div>

                    <div class="row">
                        <div class="col-md-6">
                                <?= $form->field($model, 'cv_adjunto')->fileInput() ?>
                        </div>
                        <div class="col-md-6">
                                <?= $form->field($model, 'tipo_abogado')->checkbox(['data-toggle'=>'toggle', 'data-on'=>'Interno','data-off'=> 'Externo', 'onchange'=>'checkbox_abogado(this,".field-abogadoform-consulta_info>label");']) ?>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'fk_nacionalidad')->dropDownList(ArrayHelper::map($nacionalidad,'id','nombre'),
                                ['prompt'=> 'Seleccione su nacionalidad','onchange'=>'habilitar_campo(this,"#abogadoform-provincia")']) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'provincia')->dropDownList(ArrayHelper::map($provincia,'id','nombre'),
                                ['prompt'=>'Seleccione la pronvincia','disabled'=>True,
                                'onchange'=>'cargar_municipio(this,"#abogadoform-fk_municipio");habilitar_campo(this,"#abogadoform-fk_municipio");']) ?>
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
                            ->label("3. ¿Tiene experiencia consultando?") ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-offset-1 col-lg-11">
                                <?= Html::submitButton('Registrarse', ['class' => 'btn btn-primary']) ?>
                            </div>
                        </div>
                </div>
            </div>
            <ol class="carousel-indicators" id="list" ">
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