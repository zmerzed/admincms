<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// config.php must be first in the sequence of importing
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/functions.php';
// functions.php must be first in the sequence of importing
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/auth.php';

if (!isAuthenticated()) {
    header('location: ' . '/login.php');
} else {
    header('location: ' . '/dashboard');

}
