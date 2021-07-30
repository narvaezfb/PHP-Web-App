<?php 
/*
*Name: Fabian Narvaez
*Date: 2020-09-11
*last modified: 2020-11-16
*Course Code Webd 3201
http://opentech.durhamcollege.org/webd3201/narvaezgoyesf/Lab1/sign-in.php
*/
?>
<!--*Name: Fabian Narvaez
    *Date: 2020-09-11
    *Course Code Webd 3201
-->
<!doctype html>
<html lang="en">
  <head>
  <?php 
    //start session
    session_start();
    ob_start();

    //required files for database constants and functions
    require("./includes/constants.php");
    require("./includes/db.php");
    require("./includes/functions.php");
    
    //variable message that will be used in dashboard and home page
    $message = "";
    //it will store the usertype from the users table
    $user_type= "";
    //it will store the user email since it is the way of authentication
    $user="";
    //it will store the user id from users table
    $userId ="";
    //it will store the user nmame
    $userName = "";
    //if session message is not set yet
    if (isset($_SESSION['message']))
    {
        //set message variable igual to session message
        $message = $_SESSION['message'];
        //unset the session message so It can display once per instance
        unset($_SESSION['message']);
    }
    
    //if session userr_type is not set yet
    if (isset($_SESSION['user_type']))
    {    
        $user_type = $_SESSION['user_type'];
    }

    //if session user is not set yet
    if (isset($_SESSION['user']))
    {    
        $user = $_SESSION['user'];
    }

    //if session userId is not set yet
    if (isset($_SESSION['userId']))
    {    
        $userId = $_SESSION['userId'];
    }

    //if session user name is not set yet
    if (isset($_SESSION['userName']))
    {    
        $userName = $_SESSION['userName'];
    }
        
  ?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/styles.css" rel="stylesheet">
	
  </head>
  <body>
  <?php 
    
    //if session has not started. the navigation bar will not appear
    if (isset($_SESSION['user']))
    {     
    echo '<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="index.php">Hi! '. $userName .'</a>
        <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="logout.php">Sign out</a>
        </li>
        </ul>
    </nav>
    <div class="container-fluid">
      <div class="row">
        
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
            <ul class="nav flex-column">
                <li class="nav-item">
                <a class="nav-link active" href="#">
                    <span data-feather="home"></span>
                    Dashboard <span class="sr-only">(current)</span>
                    
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <span data-feather="file"></span>
                    Home Page
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="dashboard.php">
                    <span data-feather="file"></span>
                    Dashboard
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file"></span>
                    Orders
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="salespeople.php">
                    <span data-feather="file"></span>
                    Sales People
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="clients.php">
                    <span data-feather="file"></span>
                    Clients 
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="calls.php">
                    <span data-feather="file"></span>
                    Calls
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="change-password.php">
                    <span data-feather="file"></span>
                    Change password
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="shopping-cart"></span>
                    Products
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="users"></span>
                    Customers
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="bar-chart-2"></span>
                    Reports
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="layers"></span>
                    Integrations
                </a>
                </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Saved reports</span>
                <a class="d-flex align-items-center text-muted" href="#">
                <span data-feather="plus-circle"></span>
                </a>
            </h6>
            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Current month
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Last quarter
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Social engagement
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Year-end sale
                </a>
                </li>
            </ul>
            </div>
        </nav>

        <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">';
    }
?>