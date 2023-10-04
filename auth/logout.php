<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/functions.php';

unset($_SESSION['auth']);

header('location: /login.php')
?>