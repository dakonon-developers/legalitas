<?php
// # Create Payment using PayPal as payment method
// This sample code demonstrates how you can process a 
// PayPal Account based Payment.
// API used: /v1/payments/payment
// require __DIR__ . '/../bootstrap.php';
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
            'AZl3I48baDm4BGsILA05icnn5UauIObxmUPJkRYzNBOIUwuFoJJEjswiFTSnc90yJPEVPdDioNp0-izK',     // ClientID
            'EG1WryIO0cTSgFTT9bY0Y2Sm63r7tjtR4igKogqvsqFulOxutoO9SDEfVd-nw9j4qKpgJk9dkqqtFw3F'      // ClientSecret
        )
    );
// ### Payer
// A resource representing a Payer that funds a payment
// For paypal account payments, set payment method
// to 'paypal'.
$creditCard = new \PayPal\Api\CreditCard();
$creditCard->setType("visa")
    ->setNumber("4417119669820331")
    ->setExpireMonth("11")
    ->setExpireYear("2019")
    ->setCvv2("012")
    ->setFirstName("Joe")
    ->setLastName("Shopper");
// 4. Make a Create Call and Print the Card
try {
    $creditCard->create($apiContext);
    echo "a";
}
catch (\PayPal\Exception\PayPalConnectionException $ex) {
	echo "b";
    // This will print the detailed information on the exception. 
    //REALLY HELPFUL FOR DEBUGGING
    echo $ex->getData();
}

  // ****************************************************
$card = $creditCard;
$precio=10;
$fi = new \PayPal\Api\FundingInstrument();
$fi->setCreditCardToken($card);
// $fi->setCreditCardToken();
// Set payer to process credit card
$payer = new \PayPal\Api\Payer();
$payer->setPaymentMethod("credit_card")
->setFundingInstruments(array($fi));
// $payer = new Payer();
// $payer->setPaymentMethod("paypal");
// // ### Itemized information
// // (Optional) Lets you specify item wise
// // information
// $item1 = new Item();
// $item1->setName('Ground Coffee 40 oz')
//     ->setCurrency('USD')
//     ->setQuantity(1)
//     ->setSku("123123") // Similar to `item_number` in Classic API
//     ->setPrice(7.5);
// $item2 = new Item();
// $item2->setName('Granola bars')
//     ->setCurrency('USD')
//     ->setQuantity(5)
//     ->setSku("321321") // Similar to `item_number` in Classic API
//     ->setPrice(2);
// $itemList = new ItemList();
// $itemList->setItems(array($item1, $item2));
// ### Additional payment details
// Use this optional field to set additional
// payment information such as tax, shipping
// charges etc.
// $details = new Details();
// $details->setShipping(1.2)
//     ->setTax(1.3)
//     ->setSubtotal(17.50);
echo "d\n";
$details = new \PayPal\Api\Details();
$details->setShipping(0.03)
->setTax(0.03)
->setSubtotal($precio);
// Set total amount
$amount = new \PayPal\Api\Amount();
$amount->setCurrency("USD")
->setTotal($precio)
->setDetails($details);
// ### Amount
// Lets you specify a payment amount.
// You can also specify additional details
// such as shipping, tax.
// $amount = new Amount();
// $amount->setCurrency("USD")
//     ->setTotal(20)
//     ->setDetails($details);
// ### Transaction
// A transaction defines the contract of a
// payment - what is the payment for and who
// is fulfilling it. 
echo "e\n";
$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setItemList($itemList)
    ->setDescription("Payment description")
    ->setInvoiceNumber(uniqid());
// ### Redirect urls
// Set the urls that the buyer must be redirected to after 
// payment approval/ cancellation.
echo "e.1\n";
$baseUrl = "http://localhost/LEGALITAS/legalitas/web/";//getBaseUrl();
$redirectUrls = new RedirectUrls();
echo "e.2\n";
$redirectUrls->setReturnUrl("$baseUrl/ExecutePayment.php?success=true")
    ->setCancelUrl("$baseUrl/ExecutePayment.php?success=false");
 echo "e.3\n";
// ### Payment
// A Payment Resource; create one using
// the above types and intent set to 'sale'
$payment = new Payment();
echo "e.4\n";
$payment->setIntent("sale")
    ->setPayer($payer)
    ->setRedirectUrls($redirectUrls)
    ->setTransactions(array($transaction));
echo "e.5\n";
// For Sample Purposes Only.
$request = clone $payment;
// ### Create Payment
// Create a payment by calling the 'create' method
// passing it a valid apiContext.
// (See bootstrap.php for more on `ApiContext`)
// The return object contains the state and the
// url to which the buyer must be redirected to
// for payment approval
echo "f\n";
try {
    $payment->create($apiContext);
	echo "siiiiiiiiiiiiiiiiiiiiiiiiiii";
} catch (Exception $ex) {
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    echo "Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", null, $request, $ex;
    echo "NOOOOOOOOOOOOOOO";
    
}
// ### Get redirect url
// The API response provides the url that you must redirect
// the buyer to. Retrieve the url from the $payment->getApprovalLink()
// method
$approvalUrl = $payment->getApprovalLink();
// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
echo "Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", "<a href='$approvalUrl' >$approvalUrl</a>", $request, $payment;
// return $payment;

?>