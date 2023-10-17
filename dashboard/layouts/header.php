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

    <!---Bar Chart Libraries--->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 

    <!--Graphical Chart Libraries--->
    <script src='https://cdn.plot.ly/plotly-2.26.0.min.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js'></script>

    <!-- Modal Bootstrap for stock  in and out style-->
    <style>
        
        .modal-dialog {
            max-width: 600px; 
        }
        .modal-content {
            border-radius: 10px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); 
            background-color: rgba(255, 255, 255, 0.4);
        }
        .modal-header {
            background-color: #343a40; 
            color: #fff;  
        }
        .modal-title {
            font-weight: bold; 
        }
        .modal-body {
            padding: 30px; 
        }
        .modal-body input {
            width: 100%; 
            margin-bottom: 20px;
            background-color: rgba(255, 255, 255, 0.5);
        }
    </style>
    

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