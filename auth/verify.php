<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/auth.php';
$username = $_POST['username'];
$password = $_POST['password'];

$isLogin = login($username, $password);

if ($isLogin) {
  $page = auth()->access_level == 1 ? '/dashboard/' : '/dashboard/stocks';
  header('location: ' . $page);
} else {
  $_SESSION['login_error'] = 'Invalid username or password';
  header('location: ' . '/login.php');
}