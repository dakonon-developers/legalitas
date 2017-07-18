<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\LegalitasAsset;
use app\widgets\Alert;

LegalitasAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerLinkTag(['rel'=>'icon', 'type'=>'image/png', 'href'=>Url::to(['/favicon.png'])])?>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/img/legalitas-logo.png',['width'=>'250px']),
        'brandUrl' => '',
        'options' => [
            'class' => 'legalitas-navbar',
        ],
    ]);
    $menuItems = [
        ['label' => 'HOME', 'url' => ['/site/index']],
    ];
    if(Yii::$app->user->isGuest){
        $menuItems[] = ['label' => 'LEGÁLITAS', 'url' => ['/site/legalitas']];
        $menuItems[] = ['label' => 'SERVICIOS', 'url' => ['/site/servicios']];
        $menuItems[] = ['label' => 'CONTRATA', 'url' => ['/site/contrata']];
        $menuItems[] = ['label' => 'REGISTRARSE', 'items' => [
           ['label' => 'Como Usuario', 'url' => ['/site/user-register']],
           ['label' => 'Como Abogado', 'url' => ['/site/abogado-register']], 
        ]];
        $menuItems[] = ['label' => 'ENTRAR', 'url' => ['/site/login']];
    }
    else{
        if(Yii::$app->user->can('Admin')){
            $menuItems[] = ['label' => 'CONSULTAS', 'url' => ['/consulta/index']];
            $menuItems[] = ['label' => 'USUARIOS', 'items' => [
           ['label' => 'Abogado', 'url' => ['/perfil-abogado/index']],
           ['label' => 'Usuario', 'url' => ['/perfil-usuario/index']], 
        ]];
        }
        else{
            $menuItems[] = ['label' => 'LEGÁLITAS', 'url' => ['/site/legalitas']];
            $menuItems[] = ['label' => 'SERVICIOS', 'url' => ['/site/servicios']];
            $menuItems[] = ['label' => 'CONTRATA', 'url' => ['/site/contrata']];
        }
        $menuItems[] = ['label' => 'SALIR', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <aside class="green-color"></aside>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <div class="row">
            <?= Alert::widget() ?>
        </div>
        <?= $content ?>
    </div>
</div>

<footer class="footer green-color">
    <div class="col-md-12">
        <div class="col-md-4 text-center"><a href="#">WHATSAPP <br><span class="small">Tel. 829.649.8888</span></a></div>
        <div class="col-md-4 text-center" id="separador"><a href="#">EMAIL <br><span class="small">contacto@legalitasrd.com</span></a></div>
        <div class="col-md-4 text-center"><a href="#">INSTAGRAM <br><span class="small">@LegalitasRD</span></a></div>
    </div>
</footer>

<?php $this->endBody() ?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#abogadoform-foto_documento_identidad, #usuarioform-foto_documento_identidad").fileinput({
            showCaption: true,
            previewFileType: "image",
            browseClass: "btn btn-success",
            browseLabel: "Subir Imagen del Documento",
            browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
            removeLabel: "Eliminar",
            uploadLabel:"Actualizar",
            allowedFileExtensions: ['svg','jpg', 'png', 'jpeg']
        });

        $("#abogadoform-foto_carnet").fileinput({
            showCaption: true,
            previewFileType: "image",
            browseClass: "btn btn-success",
            browseLabel: "Subir Imagen del Carnet",
            browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
            removeLabel: "Eliminar",
            uploadLabel:"Actualizar",
            allowedFileExtensions: ['svg','jpg', 'png', 'jpeg']
        });

        $("#abogadoform-cv_adjunto").fileinput({
            showCaption: true,
            browseClass: "btn btn-success",
            browseLabel: "Subir Curriculum",
            removeLabel: "Eliminar",
            uploadLabel:"Actualizar",
            allowedFileExtensions: ['pdf','odt', 'doc']
        });
    });
</script>
</body>
</html>
<?php $this->endPage() ?>
