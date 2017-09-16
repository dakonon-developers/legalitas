<?php
// require __DIR__  . '/../PayPal-PHP-SDK/autoload.php';
require_once  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'PayPal-PHP-SDK'.DIRECTORY_SEPARATOR.'autoload.php';
include ('paypalApiContext.php');
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
// source: https://gist.github.com/jaypatel512/3861355780aedd694b89
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
header('Content-Type: application/json');

/*
 * FALTA:
 * colocar las Constantes como la api key
 * hacer que el $apiContext lo lea cada funcion
 * Agregar las urls bases y de success y error para colocarlas en las constantes
*/

// https://github.com/paypal/PayPal-PHP-SDK/wiki/Making-First-Call
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AZl3I48baDm4BGsILA05icnn5UauIObxmUPJkRYzNBOIUwuFoJJEjswiFTSnc90yJPEVPdDioNp0-izK',     // ClientID
        'EG1WryIO0cTSgFTT9bY0Y2Sm63r7tjtR4igKogqvsqFulOxutoO9SDEfVd-nw9j4qKpgJk9dkqqtFw3F'      // ClientSecret
    )
);

function paypalCreateCreditCard($type, $card_number, $exp_month, $exp_year, $cvc, $first_name, $last_name){
    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'AZl3I48baDm4BGsILA05icnn5UauIObxmUPJkRYzNBOIUwuFoJJEjswiFTSnc90yJPEVPdDioNp0-izK',     // ClientID
            'EG1WryIO0cTSgFTT9bY0Y2Sm63r7tjtR4igKogqvsqFulOxutoO9SDEfVd-nw9j4qKpgJk9dkqqtFw3F'      // ClientSecret
        )
    );
  /* $creditCard->setType("visa")
      ->setNumber("4417119669820331")
      ->setExpireMonth("11")
      ->setExpireYear("2019")
      ->setCvv2("012")
      ->setFirstName("Joe")
      ->setLastName("Shopper");
  */
  // https://developer.paypal.com/webapps/developer/docs/api/#store-a-credit-card
  $creditCard = new \PayPal\Api\CreditCard();
  $creditCard->setType($type)
      ->setNumber($card_number)
      ->setExpireMonth($exp_month)
      ->setExpireYear($exp_year)
      ->setCvv2($cvc)
      ->setFirstName($first_name)
      ->setLastName($last_name);
  try {
      $creditCard->create($apiContext);
      return $creditCard;
  }
  catch (\PayPal\Exception\PayPalConnectionException $ex) {
      echo $ex->getData();
      return $ex->getData();
  }

}

function chargeToCustomer($card_obj, $card_id, $precio, $description){
  $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'AZl3I48baDm4BGsILA05icnn5UauIObxmUPJkRYzNBOIUwuFoJJEjswiFTSnc90yJPEVPdDioNp0-izK',     // ClientID
            'EG1WryIO0cTSgFTT9bY0Y2Sm63r7tjtR4igKogqvsqFulOxutoO9SDEfVd-nw9j4qKpgJk9dkqqtFw3F'      // ClientSecret
        )
    );
  // precio en valor normal, ej. un dolar: 1.0
  // source: https://github.com/paypal/PayPal-PHP-SDK/blob/master/lib/PayPal/Api/CreditCard.php
  if (!$card_obj){
    $creditCard = new \PayPal\Api\CreditCard();
    $creditCard = $creditCard->get($card_id, $apiContext);
  }else{
    $creditCard = $card_obj;
  }

  // $fi = new \PayPal\Api\FundingInstrument();
  // $fi->setCreditCardToken($card);
  // $payer->setPaymentMethod("credit_card")
  // ->setFundingInstruments(array($fi));
  $payer = new \PayPal\Api\Payer();
  $payer->setPaymentMethod("paypal");
  $details = new \PayPal\Api\Details();
  $details->setSubtotal($precio);
  $amount = new \PayPal\Api\Amount();
  $amount->setCurrency("USD")
    ->setTotal($precio)
    ->setDetails($details);
  $transaction = new Transaction();
  $transaction->setAmount($amount)
  ->setDescription($description)
  ->setInvoiceNumber(uniqid());
  $baseUrl = "http://localhost/LEGALITAS/legalitas/web";
  $redirectUrls = new RedirectUrls();
  $redirectUrls->setReturnUrl("$baseUrl/site/execute-payment?success=true")
    ->setCancelUrl("$baseUrl/site/execute-payment?success=false");
  $payment = new Payment();
  $payment->setIntent("sale")
    ->setPayer($payer)
    ->setRedirectUrls($redirectUrls)
    ->setTransactions(array($transaction));
  $request = clone $payment;
  try {
    $payment->create($apiContext);
    
  } catch (PayPal\Exception\PayPalConnectionException $ex) {
      // echo $ex->getCode(); // Prints the Error Code
      // echo $ex->getData(); // Prints the detailed error message 
      echo "Error in Payment\n";
      echo $ex->getCode(); // Prints the Error Code
    echo $ex->getData(); // Prints the detailed error message 
    echo "NOOOOOOOOOOOOOOO";
    die($ex);
  } catch (Exception $ex) {
      die($ex);
  }
  $approvalUrl = $payment->getApprovalLink();
  echo "<h1>Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", "<a href='$approvalUrl' >$approvalUrl</a></h2>";//, $request, $payment;
  return $payment;

}

function paypalCreatePlan($amount, $name, $description, $interval="Month"){
  $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'AZl3I48baDm4BGsILA05icnn5UauIObxmUPJkRYzNBOIUwuFoJJEjswiFTSnc90yJPEVPdDioNp0-izK',     // ClientID
            'EG1WryIO0cTSgFTT9bY0Y2Sm63r7tjtR4igKogqvsqFulOxutoO9SDEfVd-nw9j4qKpgJk9dkqqtFw3F'      // ClientSecret
        )
    );
  // Create a new billing plan
  $plan = new Plan();
  $plan->setName($name)
    ->setDescription($description)
    ->setType('fixed');

  // Set billing plan definitions
  $paymentDefinition = new PaymentDefinition();
  $paymentDefinition->setName('Regular Payments for '.$name)
    ->setType('REGULAR')
    ->setFrequency($interval)
    ->setFrequencyInterval('1')
    ->setCycles('12')
    ->setAmount(new Currency(array('value' => $amount, 'currency' => 'USD')));

  // Set charge models
  $chargeModel = new ChargeModel();
  $chargeModel->setType('SHIPPING') // TAX
    ->setAmount(new Currency(array('value' => $amount, 'currency' => 'USD')));
  $paymentDefinition->setChargeModels(array($chargeModel));

  // Set merchant preferences
  $merchantPreferences = new MerchantPreferences();
  $merchantPreferences->setReturnUrl('http://localhost:3000/processagreement')
    ->setCancelUrl('http://localhost:3000/cancel')
    ->setAutoBillAmount('yes')
    ->setInitialFailAmountAction('CONTINUE')
    ->setMaxFailAttempts('0')
    ->setSetupFee(new Currency(array('value' => 0, 'currency' => 'USD')));

  $plan->setPaymentDefinitions(array($paymentDefinition));
  $plan->setMerchantPreferences($merchantPreferences);


  //create plan
  try {
    $createdPlan = $plan->create($apiContext);

    try {
      $patch = new Patch();
      $value = new PayPalModel('{"state":"ACTIVE"}');
      $patch->setOp('replace')
        ->setPath('/')
        ->setValue($value);
      $patchRequest = new PatchRequest();
      $patchRequest->addPatch($patch);
      $createdPlan->update($patchRequest, $apiContext);
      $plan = Plan::get($createdPlan->id, $apiContext);

      
      // Output plan id
      return $plan;


    } catch (PayPal\Exception\PayPalConnectionException $ex) {
      echo $ex->getCode();
      echo $ex->getData();
      die($ex);
    } catch (Exception $ex) {
      die($ex);
    }
  } catch (PayPal\Exception\PayPalConnectionException $ex) {
    echo $ex->getCode();
    echo $ex->getData();
    die($ex);
  } catch (Exception $ex) {
    die($ex);
  }

}

function createSubscriptionStepOne($card_id, $plan_id){
  $apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AZl3I48baDm4BGsILA05icnn5UauIObxmUPJkRYzNBOIUwuFoJJEjswiFTSnc90yJPEVPdDioNp0-izK',     // ClientID
        'EG1WryIO0cTSgFTT9bY0Y2Sm63r7tjtR4igKogqvsqFulOxutoO9SDEfVd-nw9j4qKpgJk9dkqqtFw3F'      // ClientSecret
    )
  );
  $creditCard = new \PayPal\Api\CreditCard();
  $card = $creditCard->get($card_id, $apiContext);
  $now = new DateTime('now', new DateTimeZone('Europe/Zurich'));
  $now->modify('+5 minutes');
  $agreement = new Agreement();
  $agreement->setName('Subscription for '.$name)
    ->setDescription('Subscription for '.$name)
    ->setStartDate($now->format(DateTime::ATOM));

  $plan = new Plan();
  $plan->setId($plan_id);
  $agreement->setPlan($plan);

  $creditCardToken = new CreditCardToken();
  $creditCardToken->setCreditCardId($card->getId());
  $fi = new FundingInstrument();
  $fi->setCreditCardToken($creditCardToken);
  $fi->setCreditCard($card);
  // Set payer to process credit card
  $payer = new Payer();
  $payer->setPaymentMethod("paypal");
  // $payer->setPaymentMethod("credit_card")
  //   ->setFundingInstruments(array($fi));
  $agreement->setPayer($payer);
  try {
    $agreement = $agreement->create($apiContext);
    $approvalUrl = $agreement->getApprovalLink();
    return $agreement;
  } catch (PayPal\Exception\PayPalConnectionException $ex) {
    return $ex->getData();
  } catch (Exception $ex) {
    die($ex);
  }
}

function getPaymentInfo($id){
  $apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AZl3I48baDm4BGsILA05icnn5UauIObxmUPJkRYzNBOIUwuFoJJEjswiFTSnc90yJPEVPdDioNp0-izK',     // ClientID
        'EG1WryIO0cTSgFTT9bY0Y2Sm63r7tjtR4igKogqvsqFulOxutoO9SDEfVd-nw9j4qKpgJk9dkqqtFw3F'      // ClientSecret
    )
  );

  $payment = new \PayPal\Api\Payment();
  return $payment->get($id, $apiContext);
}
?>