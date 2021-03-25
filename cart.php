<!-- Cart layout taken from AllPHPTricks by Javed Ur Rehman https://www.allphptricks.com/simple-shopping-cart-using-php-and-mysql/-->
<!-- CSS, naigation layout taken from Mohamed Hasan https://github.com/priyesh18/book-store-->
<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login1.php");
    exit;
}

//Include the functions page that has the functions total_items(), get_cats(), getbooks(), and getbycat() required for this login.
include("function/functions.php");
//Includes the database connection so that data can be written or selected from table in the database.
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
</head>

<body>

    <!-- Navbar will come here -->

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
                    <li ><a href="index.php">Home</a></li>
                    <li><a href="successpay.php">Order Status</a></li>
                    <?php 
                    
                    
                   //To check if a person is logged in and that will determine if login is displayed on nav bar or if logout is displayed.
                    if(!isset($_SESSION['email'])){
                        echo "<li><a href='login1.php'>Login</a></li>";
                    }
                    else 
                    {
                        echo "<li><a href='logout.php'>Logout</a></li>";
                    }
                    //If a person is logged in the email address will be displayed with welcome + the email address. 
                     if(isset($_SESSION['email'])){
                        $sess=$_SESSION['email'];
                        echo "<li><a>Welcome ".$_SESSION['email']."  ".$_SESSION['cust_id']."!</a></li>";
                        
                    }
                    //If they are not logged in then it will just display guest.
                    else {
                        echo "<li><a>Guest</a></li>";
                    }
                    ?>
                   
                    <li class="active"><a href="cart.php">my Cart<span class="badge"><?php total_items(); ?></span></a></li>
                    
                </ul>
            </div>
        </div>
    </nav>

    <!-- end navbar -->
    <!-- This will display the items that are in the cart using the mycart() function. Including the name of the item, the quantity, the price, 
            and a place to remove the item. -->
    <div class="container">
        <table class="table-striped table">
            <thead class="thead-inverse">
                <tr>
                    <th>Remove</th>
                    <th></th>
                    <th>Item Name </th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <form action="cart.php" method="post">
                <?php mycart(); ?>

         
        <!-- This will display a button that when clicked will remove the selected item by using the PHP process below. -->
        <div align="right">
            <button name="update_cart" type="submit" class="btn btn-danger">Remove</button>   
        </div>
                </form>
   </tbody>

        </table>
      
    </div>
    <?php
    //Set session id cust_id to variable $id.
    $id = $_SESSION['cust_id'];
    //Once update_cart is posted
    if(isset($_POST['update_cart']))
   {
       //Once remove button is clicked the book will be removed from the list.
       foreach($_POST['remove'] as $remove_id){
           $delete_books = "delete from cart where bookid = '$remove_id' AND cust_id = '$id'";
           //To run the query to delete the book.
          $run_delete = mysqli_query($con, $delete_books);
              //When the query is run the page will update with the removed book gone.
              if($run_delete){
                   echo "<script>window.open('cart.php','_self');</script>";
           }
        }
   }
        ?>

    <div class="container" align="right" ><h3> <a  style="text-decoration:none " href="checkout.php">checkout </a></h3>
          </div>

</body>

<!--   Core JS Files   -->
<script src="assets/js/jquery.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/js/material.min.js"></script>

<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="assets/js/nouislider.min.js" type="text/javascript"></script>

<!--  Plugin for the Datepicker, full documentation here: http://www.eyecon.ro/bootstrap-datepicker/ -->
<script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>

<!-- Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc -->
<script src="assets/js/material-kit.js" type="text/javascript"></script>

</html>