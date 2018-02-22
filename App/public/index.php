<?php


session_start();

$_SESSION['user_id'] = 1;

require __DIR__.'/../../vendor/autoload.php';

use App\libs\CreatePayment;
use App\libs\Database;
use App\libs\PaypalApi;

$api = PaypalApi::getApiInstace();

$api->setConfig([
		'mode'=>'sandbox',
		'http.ConnectionTimeOut' => 30,
		'log.LogEnabled'=> false,
		'log.FileName'=>'',
		'log.LogLevel'=>'FINE',
		'validation.level' => 'log'
	]
);

/* Donation Amount */

if(isset($_POST['submit'])){

	$amount = $_POST['donation'];

	if ($amount <= 0) {
		$amount = 10;
	}
}else{
	$amount = 10;
}

$shipping = 0.00;
$tax = 0.00;
$subtotal = $amount;
$total = $shipping + $tax + $subtotal;

// Create Payment
$createPayment = new CreatePayment($api);

// Set Payment Method

$createPayment->setPaymentMethod('paypal');

// Details
$createPayment->setDetails([
	'setShipping' => $shipping,
	'setTax' => $tax,
	'setSubtotal' => $subtotal
]);
// Amount

$createPayment->setAmount([
	'setCurrency' => 'USD',
	'setTotal' => $total,
	'setDetails' => $createPayment->getDetails()
]);

// Transaction

$createPayment->setTransaction([
	'setAmount' => $createPayment->getAmount(),
	'setDescription' => 'Membership'
]);

// Redirect Urls

$doccument_root = 'http://localhost/payment/Paypal-Payment-Integrate-with-REST-API';

$createPayment->setRedirectUrl([
	'setReturnUrl' => $doccument_root.'/App/libs/pay.php?success=true',
	'setCancelUrl' => $doccument_root.'/App/libs/pay.php?success=false'
]);

// Payment
$createPayment->setPayment([
	'setIntent' => 'sale',
	'setPayer' => $createPayment->getPayer(),
	'setTransactions' => array($createPayment->getTransaction()),
	'setRedirectUrls' => $createPayment->getRedirectUrls()
]);

// Prosess payment

$createPayment->create();