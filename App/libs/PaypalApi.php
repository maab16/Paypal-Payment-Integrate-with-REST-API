<?php

namespace App\libs;

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PaypalApi {
	private $api;
	private static $_instance=null;

	public function __construct($param = []){
		$this->api = new ApiContext(
						new OAuthTokenCredential(
							'AXJEwzJFkHSr7y1otjv-NKSbkZRyRqEBqeu0-zEhJVLlltA1URZo2yIAQAUZxgjBzHn80JtnSINXQ884',
							'EIMxQN6wg5-al0ZeslpIHbQbC6S2dZP243wVFnNWeMMA5T0a0OP5yW68Jtyd8u4eg_YHlMhEO9D9dUM-'
						)
					);
	}

	public static function getApiInstace(){
		if (!isset(self::$_instance)) {
				
			self::$_instance = new PaypalApi();
			return self::$_instance->api;
		}
		return self::$_instance->api;
	}
}