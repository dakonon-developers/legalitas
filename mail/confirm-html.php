<?php
use yii\helpers\Html;

$confirmLink = "http://192.168.18.89/legalitas/web/site/confirm?key=".$user->getAuthKey();
?>
<div class="account-confirm">
    <p>Hola <?= Html::encode($user->username) ?>,</p>

    <p>Sigue el siguiente enlace para activar tu cuenta:</p>

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
</div>
