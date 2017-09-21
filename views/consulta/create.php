<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Consulta */

$this->title = 'Realizar Consulta';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php 
	if($categoria !=62){
		if ($payment && $payment->state=="created" && !$charge->payment_usado) {
			echo "<p>Pago realizado satisfactoriamente</p>";
?>
		<h3>Datos del pago</h3>
		<div class="table-responsive">
		  <table class="table table-hover">
			<thead>
				<tr>
					<td>Estado</td>
					<td>Sub Total</td>
					<td>Precio Total</td>
					<td>Moneda</td>
					<td>Descripción</td>
					<td>Correo</td>
					<td>Nombre</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo $payment->state; ?></td>
					<td><?php echo $payment->transactions[0]->amount->details->subtotal; ?></td>
					<td><?php echo $payment->transactions[0]->amount->total ?></td>
					<td><?php echo $payment->transactions[0]->amount->currency ?></td>
					<td><?php echo $payment->transactions[0]->description ?></td>
					<td><?php echo $payment->transactions[0]->payee->email ?></td>
					<td><?php echo $payment->transactions[0]->item_list->shipping_address->recipient_name ?></td>

				</tr>
			</tbody>
		  </table>

		<div class="consulta-create">

		    <h1><?= Html::encode($this->title) ?></h1>

		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>

		</div>

<?php
		}
		else{
			echo "<p>Error al procesar el pago</p><h3>Por favor verifique su conexión a internet y recargue la página con F5 y continuar</h3>";
		}
	}else{?>
		<div class="consulta-create">

		    <h1><?= Html::encode($this->title) ?></h1>

		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>

		</div>
<?php
	}
?>
	