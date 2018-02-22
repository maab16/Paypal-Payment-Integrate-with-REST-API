<?php

namespace App\libs;

use App\libs\Database;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Exception\PayPalConnectionException;

class CreatePayment {

	protected $_pdo;

	private $api;
	private $payer;
	private $details;
	private $amount;
	private $transaction;
	private $payment;
	private $redirectUrls;

	public function __construct($api){

		$this->api = $api;

		$this->_pdo = Database::getDBInstance();

		$this->payer = new Payer();
		$this->details = new Details();
		$this->amount = new Amount();
		$this->transaction = new Transaction();
		$this->payment = new Payment();
		$this->redirectUrls = new RedirectUrls();
	}

	public function getPayer(){
		return $this->payer;
	}

	public function getDetails(){
		return $this->details;
	}

	public function getAmount(){
		return $this->amount;
	}

	public function getTransaction(){
		return $this->transaction;
	}

	public function getPayment(){
		return $this->payment;
	}

	public function getRedirectUrls(){
		return $this->redirectUrls;
	}

	public function setPaymentMethod($method){
		// Payer
		$this->payer->setPaymentMethod($method);
	}

	public function setDetails($params = []){
		foreach ($params as $param => $value) {
			$this->details->$param($value);
		}
	}

	public function setAmount($params = []){
		foreach ($params as $methodName => $arg) {
			$this->amount->$methodName($arg);
		}
	}

	public function setTransaction($params = []){
		foreach ($params as $methodName => $arg) {
			$this->transaction->$methodName($arg);
		}
	}

	public function setRedirectUrl($params = []){
		foreach ($params as $methodName => $arg) {
			$this->redirectUrls->$methodName($arg);
		}
	}

	public function setPayment($params = []){
		foreach ($params as $methodName => $arg) {
			$this->payment->$methodName($arg);
		}
	}

	public function create(){
		try{

			$this->payment->create($this->api);

			$hash = md5($this->payment->getId());

			$_SESSION['paypal_hash'] = $hash;

			$store = $this->_pdo->prepare(

				"INSERT INTO transactions(payment_id,hash,complete) VALUES(:payment_id,:hash,0)"
			);

			$store->execute([
				'payment_id' => $this->payment->getId(),
				'hash' 	=> $hash
			]);

		}catch(PayPalConnectionException $e){
			header('Location: ../public/error.php');
		}


		foreach($this->payment->getLinks() as $link){
			if ($link->getRel() == "approval_url") {
				$redirect_url = $link->getHref();
			}
		}

		header("Location: ".$redirect_url);
	}

}