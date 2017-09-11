<?php
// 1. Autoload the SDK Package. This will include all the files and classes to your autoloader
//require __DIR__  . '/vendor/paypal/PayPal-PHP-SDK/autoload.php';
require __DIR__ .'/PayPal-PHP-SDK/autoload.php';
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;

// 2. Provide your Secret Key. Replace the given one with your app clientId, and Secret
// https://developer.paypal.com/webapps/developer/applications/myapps
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AZl3I48baDm4BGsILA05icnn5UauIObxmUPJkRYzNBOIUwuFoJJEjswiFTSnc90yJPEVPdDioNp0-izK',     // ClientID
        'EG1WryIO0cTSgFTT9bY0Y2Sm63r7tjtR4igKogqvsqFulOxutoO9SDEfVd-nw9j4qKpgJk9dkqqtFw3F'      // ClientSecret
    )
);


// Create a new billing plan
$plan = new Plan();
$plan->setName("plan test form file 1")
  ->setDescription("plan hecho desde un archivo a parte para probar")
  ->setType('fixed');
$amount = 400;
// Set billing plan definitions
$paymentDefinition = new PaymentDefinition();
$paymentDefinition->setName('Regular Payments for test')
  ->setType('REGULAR')
  ->setFrequency('Month')
  ->setFrequencyInterval('2')
  ->setCycles('12')
  ->setAmount(new Currency(array('value' => $amount, 'currency' => 'USD')));

// Set charge models
$chargeModel = new ChargeModel();
$chargeModel->setType('SHIPPING') //TAX
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
      echo "***********PLAN: \n".$plan;

      echo "\nid: ". $plan->getId();


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