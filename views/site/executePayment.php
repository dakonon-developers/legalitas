<?php
header('Content-Type: application/json');
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Pago';
$request = Yii::$app->request;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php 
    	if ($request->get('success') == "true") 
    		echo "<p>Pago realizado satisfactoriamente</p>";
    	else{
    		echo "<p>Error al procesar el pago</p>";
    	}
    	$pay = $payment;
    	var_dump($payment);
    	// echo $json['details'];
	?>
	<table>
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
				<td><?php echo $payment->amount['subtotal']; ?></td>
				<td><?php echo $payment->amount['total']; ?></td>
				<td><?php echo $payment->amount['currency']; ?></td>
				<td><?php echo $payment->details['description']; ?></td>
				<td><?php echo $payment->details['email']; ?></td>
				<td><?php echo $payment->details['recipient_name']; ?></td>

			</tr>
		</tbody>
	</table>
    <code><?= __FILE__ ?></code>
</div>
