<!-- Page that displays the users orders.-->
<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login1.php");
    exit;
}

include("function/functions.php");
require_once("includes/config.php");


?> 
<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8" />


    <title>Julia's BookStore</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    <!-- CSS Files -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/material-kit.css" rel="stylesheet" />
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/pay.css" rel="stylesheet" />
</head>

<body style="margin-top:10px">

    <!-- Navbar will come here  -->
 
        <!--include("includes/navBar.php");-->
        <nav class="navbar navbar-fixed-top" role="navigation" id="topnav">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
    		</button>
                <a class="navbar-brand" href="#">Julia's BookStore</a>

            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li class="active"><a href="successpay.php">Order Status</a></li>
                    <?php 
                    
                   
                    if(!isset($_SESSION['email'])){
                        echo "<li><a href='login1.php'>Login</a></li>";
                    }
                    else 
                    {
                        echo "<li><a href='logout.php'>Logout</a></li>";
                    }
                     if(isset($_SESSION['email'])){
                        $sess=$_SESSION['email'];
                        echo "<li><a>Hi ".$_SESSION['email']." !</a></li>";
                    }
                    else {
                        echo "<li><a>Guest</a></li>";
                    }
                    ?>
                   
                    <li><a href="cart.php">Go to Cart<span class="badge"><?php total_items(); ?></span></a></li>
                    
                </ul>
            </div>

        </div>
    </nav>
    <break/>
            <div class="container2">
                <div class='left'>
                <table class='payment'>
                    <caption class='payment'> Current Order</caption>
                    <tr class="payment">
                        <th class='payment'>Confirmation Number</th>
                        <th class='payment'>Book Title</th>
                        <th class='payment'>Cost</th>
                        <th class='payment'>status</th>
                    </tr> 
                        <?php getOrders(); ?>
                </table>
                </div>
                <div class='right'>
                    <table class='payment'>
                        <caption class='payment'> Previous Order</caption>
                        <tr class="payment">
                            <th class='payment'>Confirmation Number</th>
                            <th class='payment'>Book Title</th>
                            <th class='payment'>Cost</th>
                            <th class='payment'>Status</th>
                        </tr>
                            <?php getHistory(); ?>
                    </table>
                </div>
            </div>
</body>
</html>