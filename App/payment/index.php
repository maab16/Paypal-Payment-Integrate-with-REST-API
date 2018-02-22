<?php


session_start();

$_SESSION['user_id'] = 1;

require __DIR__.'/../../vendor/autoload.php';

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

$pdo = Database::getDBInstance();

$stmt = $pdo->prepare("

	SELECT * FROM users WHERE id = ?

");

$stmt->execute([$_SESSION['user_id']]);

$user = $stmt->fetchObject();