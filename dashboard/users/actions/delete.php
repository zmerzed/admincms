<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
    // config.php must be first in the sequence of importing
    require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/functions.php';
    // functions.php must be first in the sequence of importing
    require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/auth.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/userHelper.php';
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    
    if ($id) {
        $result = userDelete($id);
        header('location: ' . '/dashboard/users');
    }
?>