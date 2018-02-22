<?php

namespace App\libs;

use App\libs\PaypalApi;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

class PaymentProcess {

	protected $api;
	protected $paymentId;
	protected $payerId;
	protected $payment;
	protected $execution;

	public function __construct($params = []){

		foreach ($params as $prop => $value) {
			$this->$prop = $value;
		}

		$this->api = PaypalApi::getApiInstace();

		// Get the paypalm payment
		$this->payment = Payment::get($this->paymentId,$this->api);

		$this->execution = new PaymentExecution();
	}

	public function executePayment(){

		$this->execution->setPayerId($this->payerId);

		// Execute paypal payment
		$this->payment->execute($this->execution,$this->api);
	}
}