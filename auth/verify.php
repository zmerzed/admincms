<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/functions.php';

$username = $_POST['username'];
$password = $_POST['password'];

$isLogin = login($username, $password);

if ($isLogin) {
  header('location: ' . '/dashboard/index.php');
} else {
  $_SESSION['login_error'] = 'Invalid username or password';
  header('location: ' . '/login.php');
}