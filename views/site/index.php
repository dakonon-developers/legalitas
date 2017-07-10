<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'LegalitasRd';
?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-md-offset-2 col-md-4">
                <?=Html::img('@web/img/home_content.jpg')?>
            </div>
            <br>
            <br>
            <br>
            <div class="col-md-offset-1 col-md-4">
                <?= Html::a('Consulta', ['consulta/create', 'categoria' => 62], ['class' => 'btn btn-home btn-block btn-flat btn-lg']) ?>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="col-md-offset-1 col-md-4">
                <?= Html::a('Solicita', '#', ['class' => 'btn btn-home btn-block btn-flat btn-lg']) ?>
            </div>
        </div>

    </div>
</div>
