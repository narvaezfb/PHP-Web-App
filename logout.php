<?php
/*
*Name: Fabian Narvaez
*Date: 2020-09-11
*Course Code Webd 3201
*/
    include './includes/header.php';

    //unset session and destroy it
    unset($_SESSION['user']);
    unset($_SESSION['message']);
    redirect("./sign-in.php");
    session_destroy();
?>
