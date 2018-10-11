<?php
session_start();

require "paypal-SDK-master/app/start.php";

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

$payer = new Payer();
$payer->setPaymentMethod("paypal");

$i = 0;
foreach($_SESSION["shopping_cart"] as $keys => $values)
{
    $sql = "SELECT * FROM product WHERE pro_id = '".$values["item_id"]."'";
    $query = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($query,MYSQLI_ASSOC);

    $item.$i = new Item();
    $item.$i->setName($row['pro_name'])
        ->setCurrency('THB')
        ->setQuantity($values["item_quantity"])
        ->setSku('#'.$row['pro_id'])
        ->setPrice($row['pro_price']);
}
$string_array = array();

for($j = 0 ; $j < $i.length() ; $j++){
  array_push($string_array,$item.$j);
}

$itemList = new ItemList();
//$itemList->setItems([$item],[$item2]);
//$itemList->setItems(array($item1, $item2));
$itemList->setItems($string_array);

// $details = new Details();
// $details->setShipping(5)
//     ->setTax(1)
//     ->setSubtotal(300);

$amount = new Amount();
$amount->setCurrency("THB")
    ->setTotal($_SESSION['grand_total']);
    // ->setDetails($details);

$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setItemList($itemList)
    ->setDescription("Test")
    ->setInvoiceNumber(uniqid());

$baseUrl = SITE_URL;
$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl("$baseUrl/success.php?success=true")
    ->setCancelUrl("$baseUrl/success.php?success=false");

$payment = new Payment();
$payment->setIntent("sale")
    ->setPayer($payer)
    ->setRedirectUrls($redirectUrls)
    ->setTransactions(array($transaction));


$request = clone $payment;


try {
    $payment->create($apiContext);
}catch (Exception $ex) {
	/* print "<pre>";
	print_r($ex);
	print "</pre>"; */
	exit(1);
}

$approvalUrl = $payment->getApprovalLink();

header("location:".$approvalUrl);
}
