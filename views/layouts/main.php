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
    $item = [];
    if(Yii::$app->user->isGuest){
        $item = ['label' => 'REGISTRARSE', 'items' => [
           ['label' => 'Como Usuario', 'url' => ['/site/user-register']],
           ['label' => 'Como Abogado', 'url' => ['/site/abogado-register']], 
        ]];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'HOME', 'url' => ['/site/index']],
            ['label' => 'LEGÁLITAS', 'url' => ['/site/legalitas']],
            ['label' => 'SERVICIOS', 'url' => ['/site/servicios']],
            ['label' => 'CONTRATA', 'url' => ['/site/contrata']],
            $item,
            Yii::$app->user->isGuest ? (
                ['label' => 'ENTRAR', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'SALIR (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
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
</body>
</html>
<?php $this->endPage() ?>
