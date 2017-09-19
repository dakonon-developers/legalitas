<?php

use PayPal\Api\Agreement;
use PayPal\Api\AgreementStateDescriptor;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Plan;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
require __DIR__ .'/PayPal-PHP-SDK/autoload.php';

$apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'AZl3I48baDm4BGsILA05icnn5UauIObxmUPJkRYzNBOIUwuFoJJEjswiFTSnc90yJPEVPdDioNp0-izK',     // ClientID
            'EG1WryIO0cTSgFTT9bY0Y2Sm63r7tjtR4igKogqvsqFulOxutoO9SDEfVd-nw9j4qKpgJk9dkqqtFw3F'      // ClientSecret
        )
    );
  $createdPlan = new \PayPal\Api\Plan();
  try {
  	$createdPlan=$createdPlan->get("P-8GT68861ER278184NHFYX7VA", $apiContext);
  	echo $createdPlan."<--------";
  } catch (\PayPal\Exception\PayPalConnectionException $ex) {
  	echo $ex;die();
  }
  try {
    $result = $createdPlan->delete($apiContext);
    return $result;
    echo "\nRESULT:\n".$result;
  } catch (\PayPal\Exception\PayPalConnectionException $ex) {
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    echo "Deleted a Plan", "Plan", $createdPlan->getId(), null, $ex;
    exit(1);
  }

  ?>