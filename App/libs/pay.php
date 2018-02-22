<?php

use App\libs\Database;
use App\libs\PaymentProcess;

session_start();
require __DIR__.'/../../vendor/autoload.php';

if (isset($_GET['success']) && $_GET['success'] === 'true') {

	$payerId = $_GET['PayerID'];

	$pdo = Database::getDBInstance();

	$payment_statement = $pdo->prepare(

		"SELECT payment_id FROM transactions WHERE hash = :hash"
	);

	$payment_statement->execute(['hash'=>$_SESSION['paypal_hash']]);

	$paymentId = $payment_statement->fetchObject()->payment_id;

	// Execute Payment

	$process = new PaymentProcess([
		'paymentId' => $paymentId,
		'payerId' => $payerId,
	]);

	$process->executePayment();

	// Update transaction

	$updateTransaction = $pdo->prepare("

		UPDATE transactions 
		SET complete = 1
		WHERE payment_id = :payment_id
	");

	$updateTransaction->execute(['payment_id' => $paymentId]);

	// Unset paypal hash

	unset($_SESSION['paypal_hash']);

	header('Location: ../public/complete.php');
	
}else{
	header("Location: ../public/cancelled.php");
}