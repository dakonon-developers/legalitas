<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'LegalitasRd';
?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-md-offset-2 col-md-4">
                <?=Html::img('@web/img/home_content.jpg')?>
            </div>
            <br><br>
            <br>
            <?php if (\Yii::$app->user->can('Usuario')):  ?>
                <div class="col-md-offset-1 col-md-4">
                    <?= Html::a('Consulta', ['consulta/create', 'categoria' => 62], ['class' => 'btn btn-home btn-block btn-flat btn-lg']) ?>
                </div>
                <br><br>
                <br><br>
                <br><br>
                <div class="col-md-offset-1 col-md-4">
                    <?= Html::a('Solicita', Url::to(['/site/solicita']), ['class' => 'btn btn-home btn-block btn-flat btn-lg']) ?>
                </div>
        <?php else: ?>
            <?php if(\Yii::$app->user->isGuest): ?>
            <div class="col-md-offset-1 col-md-4">
                <h4 class="text-center">Bienvenido a LegalitasRd</h4>
                <br/>
                <?= Html::a('Registrate Como Usuario', Url::to(['/site/user-register']), ['class' => 'btn btn-block btn-home btn-flat btn-lg']) ?>
            </div>
                <br/><br/>
                <br/><br/>
                <br/><br/>
                <br/>
            <div class="col-md-offset-1 col-md-4">
                <?= Html::a('Registrate Como Colaborador', Url::to(['/site/abogado-register']), ['class' => 'btn btn-block btn-home btn-flat btn-lg']) ?>
            </div>
            <?php else:  ?>
                <div class="col-md-offset-1 col-md-4">
                    <h4 class="text-center">Bienvenido a LegalitasRd</h4>
                </div>
            <?php endif;  ?>
        <?php endif;  ?>
        </div><br/>
        <?php if(\Yii::$app->user->isGuest): ?>
            <div class="row">
                <div class="text-center">
                    <h4>¿Ya te registraste? Entonces prueba</h4>
                    <?= Html::a('Iniciar Sesión', Url::to(['/site/login']), ['class' => 'btn btn-home btn-flat btn-lg']) ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>
