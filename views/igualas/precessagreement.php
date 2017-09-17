<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Igualas */

// $this->title = 'Planes '.$model->nombre;
// $this->params['breadcrumbs'][] = ['label' => 'Listado de Igualas', 'url' => ['list']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="igualas-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?#= $agreement ?>
    <?=
        $html_iguala_vieja
    ?>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Descripción</th>
                    <th>Pagador</th>
                    <!-- <th>Precio</th> -->
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $agreement->state ?></td>
                    <td><?= $agreement->description ?></td>
                    <td>
                        <b><?= $agreement->payer->payer_info->email ?></b> 
                        <?= $agreement->payer->payer_info->first_name ?> 
                        <?= $agreement->payer->payer_info->last_name ?>
                    </td>
                    <!-- <td>
                        <?#= $agreement->plan ?>
                    </td> -->
                </tr>
            </tbody>
        </table>
    </div>

</div>