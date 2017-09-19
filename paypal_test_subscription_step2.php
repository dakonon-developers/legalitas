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
use \PayPal\Api\Agreement;
use \PayPal\Api\FundingInstrument;
use \PayPal\Api\Payer;
header('Content-Type: application/json');
// 2. Provide your Secret Key. Replace the given one with your app clientId, and Secret
// https://developer.paypal.com/webapps/developer/applications/myapps
echo "1\n";

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'client_id',     // ClientID
        'client_secret'      // ClientSecret
    )
);

  /*********************************************/
  $token = "EC-21D186840J912114F";
  $agreement = new \PayPal\Api\Agreement();
  try {
    // ## Execute Agreement
    // Execute the agreement by passing in the token
    $agreement->execute($token, $apiContext);
  } catch (\PayPal\Exception\PayPalConnectionException $ex) {
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    echo "Executed an Agreement", "Agreement", $agreement->getId(), $token, $ex;
    exit(1);
  }

echo "Executed an Agreement", "Agreement", $agreement->getId(), $token, $agreement;
/*
try {
    $agreement = \PayPal\Api\Agreement::get($agreement->getId(), $apiContext);
} catch (Exception $ex) {
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    echo "Get Agreement", "Agreement", null, null, $ex;
    exit(1);
}
// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
echo "Get Agreement", "Agreement", $agreement->getId(), null, $agreement;
*/