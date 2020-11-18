<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login1.php");
    exit;
}
include("function/functions.php");
include("config.php");

$id = $_SESSION["cust_id"];
$address = "";
$address_err = "";
$city = "";
$city_err = "";
$state = "";
$state_err = "";
$zip = "";
$zip_err = "";
$cardname = "";
$cardname_err = "";
$cardnumber = "";
$cardnumber_err = "";
$expmonth = "";
$expmonth_err = "";
$expyear = "";
$expyear_err = "";
$cvv = "";
$cvv_err = "";

$errors[] = '';
if(isset($_POST['submit']))
{
            $regAddress = $_POST['address'];
           if(empty($_POST['address'])){
               //array_push($errors, "Address is Required");
               $address_err = "Address is Required";
            }
            elseif(!preg_match("/^[a-zA-Z0-9-' .\-]+$/i",$regAddress)){
                $address_err = "error";
                echo "<script>alert('address')</script>";
               }
            else{
                $address = $_POST['address'];
               // echo '<script>alert("'.$address.'")</script>';
            }

            $regCity = $_POST['city'];
            if(empty($_POST['city'])){
                //array_push($errors, "City is Required");
                $city_err = "City is required";
            }
            elseif(!preg_match("/^[a-zA-Z-' ]*$/",$regCity)){
                $city_err = "error";
                echo "<script>alert('city')</script>";
               }
            else{
                $city = $_POST['city'];
            }

           $regState = $_POST['state'];
           if(empty($_POST['state'])){
               // array_push($errors, "State is Required");
               $state_err = "State is required";
            }
            elseif(!preg_match("/^[a-zA-Z-' ]*$/",$regState)){
                $state_err = "error";
                echo "<script>alert('state')</script>";
               }
            else{
                $state = $_POST['state'];
            }

            $regZip = $_POST['zip'];
            if(empty($_POST['zip'])){
               //array_push($errors, "Zip is Required");
               $zip_err = "Zip is required";
            }
            elseif(!preg_match("/^[0-9]{5}(-[0-9]{4})?$/",$regZip)){
                $zip_err = "error";
                echo "<script>alert('zip')</script>";
               }
            else{
                $zip = $_POST['zip'];
            }

            $regCardName = $_POST['cardname'];
            if(empty($_POST['cardname'])){
                //array_push($errors, "Name on card is Required");
                $cardname_err = "Name for card is required";
           }
           elseif(!preg_match("/^[a-zA-Z-' ]*$/",$regCardName)){
                $cardname_err = "error";
            echo "<script>alert('cardName')</script>";
           }
           else{
                $cardname = $_POST['cardname'];
           }

           $regCardNumber = $_POST['cardnumber'];
           if(empty($_POST['cardnumber'])){
               //array_push($errors, "Card number is Required");
               $cardnumber_err = "Card number is Required";
           }
           elseif(!preg_match("/^[0-9]{16}$/",$regCardNumber)){
                $cardnumber_err = "error";
            echo "<script>alert('cardNumber')</script>";
           }
           else{
                $cardnumber = $_POST['cardnumber'];
           }

           $regExpMonth = $expmonth = $_POST['expmonth'];
            if(empty($_POST['expmonth'])){
               // array_push($errors, "Expiration month is required Required");
                $expmonth_err = "Experation Month is required";
            }
            elseif(!preg_match("/^([1-9]|1[012])$/",$regExpMonth)){
                $expmonth_err = "error";
                echo "<script>alert('expmonth')</script>";
               }
            else
            {
                $expmonth = $_POST['expmonth'];
            }

            $regExpyear =  $_POST['expyear'];
            if(empty($_POST['expyear'])){
               // array_push($errors, "Expiration year is Required");
               $expyear_err = "Experation year required";
            }
            elseif(!preg_match("/^[0-9]{2}$/",$regExpyear)){
                $expyear_err = "error";
                echo "<script>alert('expyear')</script>";
               }
            else{
                $expyear = $_POST['expyear'];
            }

            $regCvv = $cvv = $_POST['cvv'];
            if(empty($_POST['cvv'])){
               //array_push($errors, "CVV is Required");
               $cvv_err = "CVV required";
            }
            elseif(!preg_match("/^[0-9]{3}$/",$regCvv)){
                $cvv_err = "error";
                echo "<script>alert('cvv')</script>";
               }
            else{
                $cvv = $_POST['cvv'];
            }


            if(empty($address_err) && empty($city_err) && empty($state_err) && empty($zip_err) && empty($cardname_err) && empty($cardnumber_err) && empty($expmonth_err) && empty($expyear_err) && empty($cvv_err)){
                
                //$param_ecard = password_hash($cardnumber, PASSWORD_DEFAULT);
                //$ecardnumber = md5($cardnumber);
                $query = "INSERT INTO Payments (`cust_id`, `cname`, `cardnum`, `expmonth`, `expyear`, `cvv`, `baddress`, `astate`, `zip`, `city`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                if($stmt = mysqli_prepare($conn, $query)){
                    mysqli_stmt_bind_param($stmt,"ssssssssss",$param_id,$param_cname,$param_ecard,$param_expmonth,$param_expyear,$param_cvv,$param_address,$param_state,$param_zip,$param_city);
                   // echo '<script>alert("'.$address.'")</script>';
                    $param_id = intval($id);
                    $param_cname = $cardname;
                    //$param_ecard = $cardnumber;
                    //$param_ecard = password_hash($cardnumber, PASSWORD_DEFAULT);
                    $param_ecard = md5($cardnumber);
                    $param_expmonth = intval($expmonth);
                    $param_expyear = intval($expyear);
                    $param_cvv = intval($cvv);
                    $param_address = $address;
                    $param_state = $state;
                    $param_zip = intval($zip);
                    $param_city = $city;
                   // echo "<script>alert('got here')</script>";

                if(mysqli_stmt_execute($stmt)){ 
                //echo "1";
                
                   echo "<script>alert('You have successfully made a payment.')</script>";
                   ///$id = $_SESSION["cust_id"];
                    //$ip = getIpAdd();
                   $delete_books = "DELETE FROM cart WHERE cust_id = '$id'";
                   $run_delete = mysqli_query($conn, $delete_books);
                 if($run_delete){
                     echo "<script>window.open('index.php','_self');</script>";
                   }
            
            } 
           else {
               echo "<script>alert('Errors found')</script>";
            }
        }
    }
}


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

    <!--Java Script-->
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"> </script> 
    <script src="landing/js/payment.js"></script>
    </head>

<body style="margin-top:150px">

    <!-- Navbar will come here  -->

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
                    <li class="active"><a href="index.php">Home</a></li>
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
                <form action="results.php" method="get" class="navbar-form navbar-right">
                    <div class="form-group label-floating">
                        <label class="control-label">Search Books</label>
                        <input type="text" name="user_query" class="form-control">
                    </div>
                    <button type="submit" name="search" class="btn btn-round btn-just-icon btn-primary"><i class="material-icons">search</i><div class="ripple-container"></div></button>
                </form>


            </div>

        </div>
    </nav>
        <break>
            <div class="row">
                <div class="col-75">
                    <div class="container">
                       
                        <form method="post" action="payment.php">
                      
                            <div class="row">
                                <div class="col-50">
                                    <h3>Billing Address</h3>
                                    <div class="form-group">
                                    <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                                    <input type="text" id="adr" name="address" class="address" placeholder="542 W. 15th Street">
                                    <span class="error" style="display:none"></span>
                                     </div>
                                    
                                     <div class="form-group">
                                    <label for="city"><i class="fa fa-institution"></i> City</label>
                                    <input type="text" id="city" name="city" class="city" placeholder="New York">
                                    <span class="error" style="display:none"></span>
                                    </div>

                                    <div class="row">
                                        <div class="col-50">
                                        <div class="form-group">
                                            <label for="state">State</label>
                                            <input type="text" id="state" name="state" class="state" placeholder="NY">
                                            <span class="error" style="display:none"></span>
                                         </div>
                                        </div>
                                        <div class="col-50">
                                        <div class="form-group">
                                            <label for="zip">Zip</label>
                                            <input type="text" id="zip" name="zip" class="zip" placeholder="10001">
                                            <span class="error" style="display:none"></span>
                                         </div>
                                            </div>
                                    </div>
                                </div>
                                
                                <div class="col-50">
                                    <h3>Payment</h3>
                                    <label for="fname">Accepted Cards</label>
                                    <div class="icon-container">
                                        <i class="fa fa-cc-visa" style="color:navy;"></i>
                                        <i class="fa fa-cc-amex" style="color:blue;"></i>
                                        <i class="fa fa-cc-mastercard" style="color:red;"></i>
                                        <i class="fa fa-cc-discover" style="color:orange;"></i>
                                    </div>
                                    <div class="form-group">
                                    <label for="cname">Name on Card</label>
                                    <input type="text" id="cname" name="cardname" class="cardname" placeholder="John More Doe">
                                    <span class="error"  style="display:none"></span>
                                     </div>

                                    <div class="form-group">
                                    <label for="ccnum">Credit card number</label>
                                    <input type="text" id="ccnum" name="cardnumber" class="cardnumber" placeholder="11112222333344">
                                    <span class="error"  style="display:none"></span>
                                    </div>

                                    <div class="form-group">
                                    <label for="expmonth">Exp Month</label>
                                    <input type="text" id="expmonth" name="expmonth" class="expmonth" placeholder="01">
                                    <span class="error"  style="display:none"></span>
                                    </div>

                                    <div class="row">
                                        <div class="col-50">
                                        <div class="form-group">
                                            <label for="expyear">Exp Year</label>
                                           <input type="text" id="expyear" name="expyear" class="expyear" placeholder="18">
                                           <span class="error" style="display:none"></span>
                                            </div>
                                            </div>
                                        <div class="col-50">
                                             <div class="form-group">
                                            <label for="cvv">CVV</label>
                                            <input type="text" id="cvv" name="cvv" class="cvv" placeholder="352">
                                            <span class="error"  style="display:none"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <input type="submit" name="submit" id="submit" value="Continue to checkout" class="btn">
                        </form>
                    </div>
                </div>
            </div>
            
    <!-- end navbar -->
