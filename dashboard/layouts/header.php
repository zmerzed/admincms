<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard Simsa</title>
    <link href="/css/styles.css" rel="stylesheet" />
    <script src="/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
<div id="layoutSidenav">

<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
    // config.php must be first in the sequence of importing
    require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/functions.php';
    // functions.php must be first in the sequence of importing
    require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/auth.php';

    if (!isAuthenticated()) {
        header('location: ' . '/login.php');
    }
?>