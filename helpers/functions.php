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

function dd($data) {

	echo '<pre>';
	print_r($data);
	echo '</pre>';
	exit();
}

function displayErrors($errors) {

	$errorStr = '<div class="col text-danger errors">';

	foreach ($errors as $error) {

		$errorStr .= $error;
	}

	$errorStr .= "</div>";

	return $errorStr;
}