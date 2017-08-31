<?php
// require __DIR__  . '/../PayPal-PHP-SDK/autoload.php';
require_once  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'PayPal-PHP-SDK'.DIRECTORY_SEPARATOR.'autoload.php';
// source: https://gist.github.com/jaypatel512/3861355780aedd694b89
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;

// https://github.com/paypal/PayPal-PHP-SDK/wiki/Making-First-Call

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AZl3I48baDm4BGsILA05icnn5UauIObxmUPJkRYzNBOIUwuFoJJEjswiFTSnc90yJPEVPdDioNp0-izK',     // ClientID
        'EG1WryIO0cTSgFTT9bY0Y2Sm63r7tjtR4igKogqvsqFulOxutoO9SDEfVd-nw9j4qKpgJk9dkqqtFw3F'      // ClientSecret
    )
);

function paypalCreateCreditCard($type, $card_number, $exp_month, $exp_year, $cvc, $first_name, $last_name){
  /* $creditCard->setType("visa")
      ->setNumber("4417119669820331")
      ->setExpireMonth("11")
      ->setExpireYear("2019")
      ->setCvv2("012")
      ->setFirstName("Joe")
      ->setLastName("Shopper");
  */
  // 3. Lets try to save a credit card to Vault using Vault API mentioned here
  // https://developer.paypal.com/webapps/developer/docs/api/#store-a-credit-card
  $creditCard = new \PayPal\Api\CreditCard();
  $creditCard->setType($type)
      ->setNumber($card_number)
      ->setExpireMonth($exp_month)
      ->setExpireYear($exp_year)
      ->setCvv2($cvc)
      ->setFirstName($first_name)
      ->setLastName($last_name);
  // 4. Make a Create Call and Print the Card
  try {
      $creditCard->create($apiContext);
      // echo $creditCard;
      return $creditCard;
  }
  catch (\PayPal\Exception\PayPalConnectionException $ex) {
      // This will print the detailed information on the exception. 
      //REALLY HELPFUL FOR DEBUGGING
      echo $ex->getData();
      return $ex->getData();
  }

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
      $plan = Plan::get($createdPlan->getId(), $apiContext);

      
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


?>