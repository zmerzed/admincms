<?php

function isAuthenticated() {
	return isset($_SESSION['auth']) && !empty($_SESSION['auth']);
}

function auth() {
    $auth = (object) $_SESSION['auth'];
    return $auth;
}