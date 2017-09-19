<?php

use PayPal\Api\Agreement;
use PayPal\Api\AgreementStateDescriptor;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
require __DIR__ .'/PayPal-PHP-SDK/autoload.php';
$apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'client_id',     // ClientID
            'client_secret'      // ClientSecret
        )
    );

	$createdAgreement = new Agreement();
    $createdAgreement = $createdAgreement->get("I-RUGKH5SYWAV9", $apiContext);
$agreementStateDescriptor = new AgreementStateDescriptor();
  $agreementStateDescriptor->setNote("Suspending the agreement");
  try {
    $createdAgreement->suspend($agreementStateDescriptor, $apiContext);
    // Lets get the updated Agreement Object
    $agreement = Agreement::get($createdAgreement->getId(), $apiContext);
  } catch (Exception $ex) {
      // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
      echo "Suspended the Agreement", "Agreement", null, $agreementStateDescriptor, $ex;
      exit(1);
  }
  echo "Suspended the Agreement", "Agreement", $agreement->getId(), $agreementStateDescriptor, $agreement;
?>