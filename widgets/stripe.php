<?php

/* DESARROLLADO POR: @pdonaire1 */
/* imoprt like this:
 * require_once  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'widgets'.DIRECTORY_SEPARATOR.'stripe.php';
 */
 //Yii::import('application.vendors.*');

require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor'.DIRECTORY_SEPARATOR.'stripe-php-5.1.2'.DIRECTORY_SEPARATOR.'init.php';
\Stripe\Stripe::setApiKey("sk_test_AHLcqAqtMbTOLWqjKHC64wkr");

/* Stripe info
 * card_number: 4242424242424242
 * exp_month: 12
 * exp_year: 2018
 * cvc: 123 (CODIGO DE SEGURIDAD QUE SE ENCUENTRA EN LA PARTE DE ATRAS DE LA
 * TARJETA)
 */

//$currency = "dop";  // source: https://stripe.com/docs/currencies


function stripeCreateToken($card_number, $exp_month, $exp_year, $cvc){
    return \Stripe\Token::create(array(
      "card" => array(
        "number" => $card_number,
        "exp_month" => $exp_month,
        "exp_year" => $exp_year,
        "cvc" => $cvc
      )
    ));
}

function stripeCreateCharge($card_token, $amount){
    /* AMOUNT IN CENTS, amount = 100 == 1DOP */
    return \Stripe\Charge::create(array(
      "amount" => $amount,
      "currency" => "dop",
      "source" => $card_token, // obtained with Stripe.js
      "description" => "Cargo simple por Legalitas de: " + $amount + $currency
    ));
}

function stripeSimpleCharge($card_number, $exp_month, $exp_year, $cvc, $amount){
    $card_token = stripeCreateToken($card_number, $exp_month, $exp_year, $cvc);
    return stripeCreateCharge($card_token->id, $amount);
}

function stripeChargeToCustomer($customer_id, $amount){

    return \Stripe\Charge::create(array(
      "amount" => $amount,
      "currency" => "dop",
      "customer" => $customer_id,
      "description" => "Charge for customer"
    ));
}

function stripeCreateCustomer($card_number, $exp_month, $exp_year, $cvc){
    $card_token = stripeCreateToken($card_number, $exp_month, $exp_year, $cvc);
    $customer = \Stripe\Customer::create(array(
      "description" => "Customer for Legalitas",
      "source" => $card_token->id
    ));
    // Adding card to customer:
    //$customer->sources->create(array("source" => $card_token["id"]));
    //stripeCreateCardToCustomer($customer -> id);
    return $customer;
}

function stripeGetCustomer($customer_id){
    return \Stripe\Customer::retrieve($customer_id);
}
/*
function stripeCreateCardToCustomer($card_number, $exp_month, $exp_year, $cvc, $customer_id){
    $customer = stripeGetCustomer($customer_id);
    $card_token = stripeCreateToken($card_number, $exp_month, $exp_year, $cvc);
    return $customer->sources->create(array("source" => $card_token["id"]));
}*/

function stripeCreatePlan($amount, $name, $id="", $interval="month"){
    return \Stripe\Plan::create(array(
      "amount" => $amount,
      "interval" => $interval,
      "name" => $name,
      "currency" => "dop",
      "id" => $id
      )
    );
}

function stripeUpdatePlan($plan_id, $amount){
  $p = \Stripe\Plan::retrieve($plan_id);
  $name = $p->name;
  $p->delete();
  return stripeCreatePlan($amount, $name, $plan_id);

}
function stripeSubscribeCustomer($customer_id, $plan_id){
    return \Stripe\Subscription::create(array(
      "customer" => $customer_id,
      "items" => array(
        array(
          "plan" => $plan_id,
        ),
      )
    ));
}

function stripeGetSubscription($subscription_id){
    return \Stripe\Subscription::retrieve($subscription_id);
}
function stripeCancelSubscription($subscription_id){
    $sub = \Stripe\Subscription::retrieve($subscription_id);
    $sub->cancel();
}

?>

