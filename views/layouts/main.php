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
        'brandLabel' => Html::img('@web/img/legalitas-logo.png',['width'=>'50%']),
        'brandUrl' => '',
        'options' => [
            'class' => 'legalitas-navbar',
        ],
    ]);
    $menuItems = [
        ['label' => 'HOME', 'url' => ['/site/index']],
    ];
    if(Yii::$app->user->isGuest){
        $menuItems[] = ['label' => 'CONTRATA', 'url' => ['/igualas/list']];
        $menuItems[] = ['label' => 'LEGÁLITAS', 'url' => ['/site/legalitas']];
        $menuItems[] = ['label' => 'REGISTRARSE', 'items' => [
           ['label' => 'Como Usuario', 'url' => ['/site/user-register']],
           ['label' => 'Como Colaborador', 'url' => ['/site/abogado-register']], 
        ]];
        $menuItems[] = ['label' => 'ENTRAR', 'url' => ['/site/login']];
    }
    else{
        // Apartado del admin
        if(Yii::$app->user->can('Admin')){
            $menuItems[] = ['label' => 'USUARIOS', 'items' => [
               ['label' => 'Abogado', 'url' => ['/perfil-abogado/index']],
               ['label' => 'Usuario', 'url' => ['/perfil-usuario/index']], 
            ]];
            $menuItems[] = ['label' => 'PAGOS', 'url' => ['/payments/index']];
            $menuItems[] = ['label' => 'ACTUACIONES', 'items' => [
               ['label' => 'Ver', 'url' => ['/consulta/index']],
               ['label' => 'Calificaciones', 'url' => ['/calificacion/index']], 
            ]];
            $menuItems[] = ['label' => 'CONFIGURACIÓN', 'items' => [
                ['label' => 'Igualas', 'url' => ['/igualas/index']],
               ['label' => 'Servicios', 'url' => ['/servicios/index']], 
               ['label' => 'Servicios - Promociones', 'url' => ['/promociones/index']],
               ['label' => 'Cobro Inicial', 'url' => ['/pagos-config/index']],
               ['label' => 'Tasa de Cambio', 'url' => ['/currency/index']],
               ['label' => 'PayPal', 'url' => ['/paypal-key/index']],
            ]];
        }
        else{
            // Actuaciones para los usuarios
            if(Yii::$app->user->can('Usuario')){
                $menuItems[] = ['label' => 'LEGÁLITAS', 'url' => ['/site/legalitas']];
                $menuItems[] = ['label' => 'CONTRATA', 'url' => ['/igualas/list']];
                $menuItems[] = ['label' => 'ACTUACIONES', 'url' => ['/site/actuaciones']];
            }
            // Actuaciones para los abogados
            else if (Yii::$app->user->can('Abogado Interno') or Yii::$app->user->can('Abogado Externo')){
                $menuItems[] = ['label' => 'ACTUACIONES', 'items' => [
                   ['label' => 'Ver', 'url' => ['/site/actuaciones']],
                   ['label' => 'Mis Calificaciones', 'url' => ['/calificacion/micalificacion']], 
                ]];
            }
            // Perfil para los usuarios
            if(Yii::$app->user->can('Usuario')){
                $menuItems[] = ['label' => 'PERFIL', 'url' => ['/perfil-usuario/update?id='.Yii::$app->user->id]];
            }
            // Perfil para los abogados
            else if (Yii::$app->user->can('Abogado Interno') or Yii::$app->user->can('Abogado Externo')){
                $menuItems[] = ['label' => 'PERFIl', 'url' => ['/perfil-abogado/update?id='.Yii::$app->user->id]];
            }
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
            <?php if(Yii::$app->user->can('Invitado')): ?>
                <div class="alert alert-info">Pendiente de validación de legalitas.</div>
            <?php endif; ?>
        </div>
        <?= $content ?>
    </div>
</div>

<footer class="footer green-color">
    <div class="col-md-12">
        <div class="col-md-4 col-xs-4 col-sm-4 text-center"><a href="#"><i class="fa fa-whatsapp"></i> WHATSAPP <br><span class="small">Tel. 829.649.8888</span></a></div>
        <div class="col-md-4 col-xs-4 col-sm-4 text-center" id="separador"><a href="#"><i class="fa fa-envelope-o"></i> EMAIL <br><span class="small">contacto@legalitasrd.com</span></a></div>
        <div class="col-md-4 col-xs-4 col-sm-4 text-center"><a href="#"><i class="fa fa-instagram"></i> INSTAGRAM <br><span class="small">@LegalitasRD</span></a></div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
