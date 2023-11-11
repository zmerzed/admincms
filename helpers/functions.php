<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/connection.php';

function login($username, $password) 
{
	global $db;
	$result = mysqli_query($db->link, "SELECT * FROM users WHERE username = '$username' and password = '$password'");

	// Fetch the next row of a result set as an associative array
	$resultData = mysqli_fetch_assoc($result);

	if (!empty($resultData)) {
		$_SESSION['auth'] = $resultData;
	}

	return empty($resultData) ? false : true;
}

function dd($data) 
{

	echo '<pre>';
	print_r($data);
	echo '</pre>';
	exit();
}

function displayErrors($errors) 
{

	$errorStr = '<div class="col text-danger errors">';

	foreach ($errors as $error) {

		$errorStr .= $error . "<br>";
	}

	$errorStr .= "</div><br>";

	return $errorStr;
}


function sendSMS($toNumber=null, $message=null) 
{

	$mainSID = 'AC442c3f897147a382c1f606a9fdef3119';
	$id = $mainSID;
	$secret = '8e1b395f3c9c94778fecd662e4980dfa';
	$url = "https://api.twilio.com/2010-04-01/Accounts/AC442c3f897147a382c1f606a9fdef3119/Messages.json";
	
	if ($message) 
	{
		$to = $toNumber; // twilio trial verified number
		$from = '+12516470370';
		$body = $message;
		$data = array (
			'From' => $from,
			'To' => $to,
			'Body' => $body,
		);
		$post = http_build_query($data);
		$x = curl_init($url );
		curl_setopt($x, CURLOPT_POST, true);
		curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($x, CURLOPT_USERPWD, "$id:$secret");
		curl_setopt($x, CURLOPT_POSTFIELDS, $post);
		//$y = curl_exec($x);
		// print_r($y);
		curl_close($x);
	}
}