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
use PayPal\Api\CreditCardToken;
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
echo "2\n";
$now = new DateTime('now', new DateTimeZone('Europe/Zurich'));
$now->modify('+5 minutes');
$creditCard = new \PayPal\Api\CreditCard();
echo "3\n";
$card = $creditCard->get('CARD-30L1581339390110YLG55XNA', $apiContext);
echo "a\n";
$agreement = new \PayPal\Api\Agreement();
echo "b\n";
$agreement->setName('Base Agreement for ')
  ->setDescription('Basic Agreement for ')
  // ->setStartDate('2019-06-17T9:45:04Z');
  ->setStartDate($now->format(DateTime::ATOM));


echo "c\n";
$plan = new Plan();
echo "d\n";
$plan->setId('P-8GT68861ER278184NHFYX7VA');
echo "e\n";
$agreement->setPlan($plan);
echo "f\n";

$creditCardToken = new CreditCardToken();
$creditCardToken->setCreditCardId($card->getId());
$fi = new FundingInstrument();
$fi->setCreditCardToken($creditCardToken);
echo "g\n";
$fi->setCreditCard($card);


echo "h\n";
// Set payer to process credit card
$payer = new Payer();
echo "i\n";
$payer->setPaymentMethod("paypal");
// $payer->setPaymentMethod("credit_card")
  // ->setFundingInstruments(array($fi));
echo "j\n";
$agreement->setPayer($payer);
echo "k\n";
// $agreement = $agreement->create($apiContext);
echo "l\n";

// echo "AGREEMENT: \n".$agreement."\n";
// json_encode($agreement, true);
// print_r( get_object_vars($agreement) );
// print_r($agreement->payer->funding_instruments);
// $token = $agreement->payer;///["funding_instruments"]["links"][0];
// $authorizationCode = "client_secret";
// $refreshToken = \PayPal\Api\FuturePayment::getRefreshToken($authorizationCode, $apiContext);
// echo "$refreshToken:\n ".$refreshToken."\n";
$request = clone $agreement;
try {
    // Please note that as the agreement has not yet activated, we wont be receiving the ID just yet.
    $agreement = $agreement->create($apiContext);
    // ### Get redirect url
    // The API response provides the url that you must redirect
    // the buyer to. Retrieve the url from the $agreement->getApprovalLink()
    // method
    $approvalUrl = $agreement->getApprovalLink();
// } catch (Exception $ex) {
//     // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
//     echo "Created Billing Agreement.", "Agreement", null, $request, $ex;
//     exit(1);
// }
    echo "$agreement\n\n$approvalUrl";
  } catch (\PayPal\Exception\PayPalConnectionException $ex) {
    die($ex);
    // echo "Created Billing Agreement.", "Agreement", null, $request, $ex;
    die(1);
  } catch (Exception $ex) {
    die($ex);
  }

/**************************************************/
/*try {
  // Execute agreement
  $agreement->execute("A21AAHGtD-WvugyMU7INSAGn24ta79aD1DiEs2Gljx2Xs173prEcuNlgh7ZBatoXJzKHQMmapZ7gFvBDi2Fn6ureK8gNSVjUQ", $apiContext);
} catch (PayPal\Exception\PayPalConnectionException $ex) {
  echo $ex->getCode();
  echo $ex->getData();
  die($ex);
} catch (Exception $ex) {
  die($ex);
}

*/


  