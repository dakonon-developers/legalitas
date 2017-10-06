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
use \PayPal\Api\Agreement;
use \PayPal\Api\Payer;
use PayPal\Api\AgreementStateDescriptor;
use app\models\PaypalKey;

/*
 * FALTA:
 * colocar las Constantes como la api key
 * hacer que el $apiContext lo lea cada funcion
 * Agregar las urls bases y de success y error para colocarlas en las constantes
*/

// https://github.com/paypal/PayPal-PHP-SDK/wiki/Making-First-Call

function paypalCreateCreditCard($type, $card_number, $exp_month, $exp_year, $cvc, $first_name, $last_name){
    $paypal_key = \app\models\PaypalKey::findOne(1);
    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            $paypal_key->client_id,     // ClientID
            $paypal_key->client_secret// ClientSecret
        )
    );
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

// function chargeToCustomer($card_obj, $card_id, $precio, $description){
function chargeToCustomer($precio, $description, $extra_url=""){
  $paypal_key = \app\models\PaypalKey::findOne(1);
  $apiContext = new \PayPal\Rest\ApiContext(
      new \PayPal\Auth\OAuthTokenCredential(
          $paypal_key->client_id,     // ClientID
          $paypal_key->client_secret// ClientSecret
      )
  );
  // precio en valor normal, ej. un dolar: 1.0
  // source: https://github.com/paypal/PayPal-PHP-SDK/blob/master/lib/PayPal/Api/CreditCard.php
  // if (!$card_obj){
  //   $creditCard = new \PayPal\Api\CreditCard();
  //   $creditCard = $creditCard->get($card_id, $apiContext);
  // }else{
  //   $creditCard = $card_obj;
  // }

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
  //$baseUrl = "http://localhost/legalitas/web";
  $baseUrl = "https://legalitas.herokuapp.com";
  $redirectUrls = new RedirectUrls();
  if ($extra_url != ""){
    $url = $baseUrl."/".$extra_url;
  }else{
    $url ="$baseUrl/site/execute-payment?success=true";
  }
  $redirectUrls->setReturnUrl($url)
    ->setCancelUrl("$baseUrl/site/execute-payment?success=false".$extra_url);
  $payment = new Payment();
  $payment->setIntent("sale")
    ->setPayer($payer)
    ->setRedirectUrls($redirectUrls)
    ->setTransactions(array($transaction));
  $request = clone $payment;
  try {
    $payment->create($apiContext);
    
  } catch (PayPal\Exception\PayPalConnectionException $ex) {
      throw new \Exception('PayPal Error: '.$ex->getMessage());
      return false;
  } catch (Exception $ex) {
      throw new \Exception('PayPal Error: '.$ex->getMessage());
      return false;
  }
  $approvalUrl = $payment->getApprovalLink();
  // echo "<h1>Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", "<a href='$approvalUrl' >$approvalUrl</a></h2>";//, $request, $payment;
  return $payment;

}

function paypalSuspendPlanToUser($agreement_id){
  // source: https://github.com/paypal/PayPal-PHP-SDK/blob/master/sample/billing/SuspendBillingAgreement.php
  $paypal_key = \app\models\PaypalKey::findOne(1);
  $apiContext = new \PayPal\Rest\ApiContext(
      new \PayPal\Auth\OAuthTokenCredential(
          $paypal_key->client_id,     // ClientID
          $paypal_key->client_secret// ClientSecret
      )
  );
  
  $createdAgreement = new Agreement();
  $createdAgreement = $createdAgreement->get($agreement_id, $apiContext);
  $agreementStateDescriptor = new AgreementStateDescriptor();
  $agreementStateDescriptor->setNote("Suspending the agreement");
  try {
    $createdAgreement->suspend($agreementStateDescriptor, $apiContext);
    // Lets get the updated Agreement Object
    $agreement = Agreement::get($createdAgreement->getId(), $apiContext);
  } catch (PayPal\Exception\PayPalConnectionException $ex) {
      throw new \Exception('PayPal Error: '.$ex->getMessage());
      return false;
  } catch (Exception $ex) {
      throw new \Exception('PayPal Error: '.$ex->getMessage());
      return false;
  }
  return $agreement;

}

function paypalDeletePlan($plan_id){
  $paypal_key = \app\models\PaypalKey::findOne(1);
  $apiContext = new \PayPal\Rest\ApiContext(
      new \PayPal\Auth\OAuthTokenCredential(
          $paypal_key->client_id,     // ClientID
          $paypal_key->client_secret// ClientSecret
      )
  );
  $createdPlan = new \PayPal\Api\Plan();
  $createdPlan=$createdPlan->get($plan_id, $apiContext);
  try {
    $result = $createdPlan->delete($apiContext);
  } catch (PayPal\Exception\PayPalConnectionException $ex) {
      throw new \Exception('PayPal Error: '.$ex->getMessage());
      return false;
  } catch (Exception $ex) {
      throw new \Exception('PayPal Error: '.$ex->getMessage());
      return false;
  }
  return $result;
}

function paypalCreatePlan($amount, $name, $description, $interval="Month"){
  $paypal_key = \app\models\PaypalKey::findOne(1);
  $apiContext = new \PayPal\Rest\ApiContext(
      new \PayPal\Auth\OAuthTokenCredential(
          $paypal_key->client_id,     // ClientID
          $paypal_key->client_secret// ClientSecret
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
    ->setCycles('6')
    ->setAmount(new Currency(array('value' => $amount, 'currency' => 'USD')));

  // Set charge models
  $chargeModel = new ChargeModel();
  $chargeModel->setType('SHIPPING') // TAX
    ->setAmount(new Currency(array('value' => $amount, 'currency' => 'USD')));
  $paymentDefinition->setChargeModels(array($chargeModel));

  // Set merchant preferences
  $merchantPreferences = new MerchantPreferences();
  //$baseUrl = "http://localhost/legalitas/web";
  $baseUrl = "https://legalitas.herokuapp.com";

  $merchantPreferences->setReturnUrl($baseUrl.'/igualas/processagreement')
    ->setCancelUrl($baseUrl.'/igualas/cancel')
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
        throw new \Exception('PayPal Error: '.$ex->getMessage());
        return false;
    } catch (Exception $ex) {
        throw new \Exception('PayPal Error: '.$ex->getMessage());
        return false;
    }
  } catch (PayPal\Exception\PayPalConnectionException $ex) {
      throw new \Exception('PayPal Error: '.$ex->getMessage());
      return false;
  } catch (Exception $ex) {
      throw new \Exception('PayPal Error: '.$ex->getMessage());
      return false;
  }

}
function createSubscriptionStepTwo($token){
  $paypal_key = \app\models\PaypalKey::findOne(1);
  $apiContext = new \PayPal\Rest\ApiContext(
      new \PayPal\Auth\OAuthTokenCredential(
          $paypal_key->client_id,     // ClientID
          $paypal_key->client_secret// ClientSecret
      )
  );

  $agreement = new \PayPal\Api\Agreement();
  try {
    // ## Execute Agreement
    // Execute the agreement by passing in the token
    $agreement->execute($token, $apiContext);
  } catch (\PayPal\Exception\PayPalConnectionException $ex) {
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    throw new \Exception('PayPal Error: '.$ex->getMessage());
    // echo "Executed an Agreement", "Agreement", $agreement->getId(), $token, $ex;
    // exit(1);
    return false;
  }
  return $agreement;
}

function createSubscriptionStepOne($plan_id, $name){ //$card_id, 
  $paypal_key = \app\models\PaypalKey::findOne(1);
  $apiContext = new \PayPal\Rest\ApiContext(
      new \PayPal\Auth\OAuthTokenCredential(
          $paypal_key->client_id,     // ClientID
          $paypal_key->client_secret// ClientSecret
      )
  );
  // $creditCard = new \PayPal\Api\CreditCard();
  // $card = $creditCard->get($card_id, $apiContext);
  $now = new DateTime('now', new DateTimeZone('Europe/Zurich'));
  $now->modify('+5 minutes');
  $agreement = new Agreement();
  $agreement->setName('Subscription for '.$name)
    ->setDescription('Subscription for '.$name)
    ->setStartDate($now->format(DateTime::ATOM));

  $plan = new Plan();
  $plan->setId($plan_id);
  $agreement->setPlan($plan);

  // $creditCardToken = new CreditCardToken();
  // $creditCardToken->setCreditCardId($card->getId());
  // $fi = new FundingInstrument();
  // $fi->setCreditCardToken($creditCardToken);
  // $fi->setCreditCard($card);
  // Set payer to process credit card
  $payer = new Payer();
  $payer->setPaymentMethod("paypal");
  // $payer->setPaymentMethod("credit_card")
  //   ->setFundingInstruments(array($fi));

  $agreement->setPayer($payer);
    // ->setReturnUrls($redirectUrls);
  try {
    $agreement = $agreement->create($apiContext);
    $approvalUrl = $agreement->getApprovalLink();
    return $agreement;
  } catch (\PayPal\Exception\PayPalConnectionException $ex) {
    throw new \Exception('PayPal Error: '.$ex->getMessage());
    return false;
  }
}

function getPaymentInfo($id){
  $paypal_key = \app\models\PaypalKey::findOne(1);
  $apiContext = new \PayPal\Rest\ApiContext(
      new \PayPal\Auth\OAuthTokenCredential(
          $paypal_key->client_id,     // ClientID
          $paypal_key->client_secret// ClientSecret
      )
  );

  $payment = new \PayPal\Api\Payment();
  try{
    return $payment->get($id, $apiContext);
  } catch (\PayPal\Exception\PayPalConnectionException $ex) {
    throw new \Exception('PayPal Error: '.$ex->getMessage());
    return false;
  }
}
?>