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
           if(empty(mysqli_escape_string($conn, $_POST['address']))){
               //array_push($errors, "Address is Required");
               $address_err = "Address is Required";
            }
            else{
                $address = mysqli_escape_string($conn, $_POST['address']);
               // echo '<script>alert("'.$address.'")</script>';
            }
            if(empty(mysqli_escape_string($conn, $_POST['city']))){
                //array_push($errors, "City is Required");
                $city_err = "City is required";
            }
            else{
                $city = mysqli_escape_string($conn, $_POST['city']);
            }
           if(empty(mysqli_escape_string($conn, $_POST['state']))){
               // array_push($errors, "State is Required");
               $state_err = "State is required";
            }
            else{
                $state = mysqli_escape_string($conn, $_POST['state']);
            }
            if(empty(mysqli_escape_string($conn, $_POST['zip']))){
               //array_push($errors, "Zip is Required");
               $zip_err = "Zip is required";
            }
            else{
                $zip = mysqli_escape_string($conn, $_POST['zip']);
            }
            if(empty(mysqli_escape_string($conn, $_POST['cardname']))){
                //array_push($errors, "Name on card is Required");
                $cardname_err = "Name for card is required";
           }
           else{
            $cardname = mysqli_escape_string($conn, $_POST['cardname']);
           }
           if(empty(mysqli_escape_string($conn, $_POST['cardnumber']))){
               //array_push($errors, "Card number is Required");
               $cardnumber_err = "Card number is Required";
           }
           else{
                $cardnumber = mysqli_escape_string($conn, $_POST['cardnumber']);
           }
            if(empty(mysqli_escape_string($conn, $_POST['expmonth']))){
               // array_push($errors, "Expiration month is required Required");
                $expmonth_err = "Experation Month is required";
            }
            else
            {
                $expmonth = mysqli_escape_string($conn, $_POST['expmonth']);
            }
            if(empty(mysqli_escape_string($conn, $_POST['expyear']))){
               // array_push($errors, "Expiration year is Required");
               $expyear_err = "Experation year required";
            }
            else{
                $expyear = mysqli_escape_string($conn, $_POST['expyear']);
            }
            if(empty(mysqli_escape_string($conn, $_POST['cvv']))){
               //array_push($errors, "CVV is Required");
               $cvv_err = "CVV required";
            }
            else{
                $cvv = mysqli_escape_string($conn, $_POST['cvv']);
            }
            if(empty($address_err) && empty($city_err)){
                
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
</head>

<body style="margin-top:10px">

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
                        echo $id;
                        //echo $city;
                       // echo $state;
                       // echo $zip;
                       // echo $cardname;
                       // echo $cardnumber;
                       // echo $expmonth;
                       // echo $expyear;
                       // echo $cvv;  
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
    <div class="container-fluid">

          <div class="c-content ">
                    <p>this is a test</p>
                </div>

    </div>

<?php
        //include("config.php");
        //$errors[] = '';
      // if(isset($_POST['submit']))
      // {
          //  $address = mysqli_escape_string($conn, $_POST['address']);
          //  $city = mysqli_escape_string($conn, $_POST['city']);
          //  $state = mysqli_escape_string($conn, $_POST['state']);
           // $zip = mysqli_escape_string($conn, $_POST['zip']);

          // $cardname = mysqli_escape_string($conn, $_POST['cardname']);
           // $cardnumber = mysqli_escape_string($conn, $_POST['cardnumber']);
           // $expmonth = mysqli_escape_string($conn, $_POST['expmonth']);
           // $expyear = mysqli_escape_string($conn, $_POST['expyear']);
           // $cvv = mysqli_escape_string($conn, $_POST['cvv']);

            
            //if($address!='')
            //{
            //    echo "<script>alert('$address')</script>";
            //}
           // if(empty($address)){
               // array_push($errors, "Address is Required");
           // }
           // if(empty($city)){
            //    array_push($errors, "City is Required");
           // }
           // if(empty($state)){
               // array_push($errors, "State is Required");
           // }
           // if(empty($zip)){
             //   array_push($errors, "Zip is Required");
            //}
           // if(empty($cardname)){
             //   array_push($errors, "Name on card is Required");
           //}
           ///if(empty($cardnumber)){
              //  array_push($errors, "Card number is Required");
           // }
           // if(empty($expmonth)){
              //  array_push($errors, "Expiration month is required Required");
           // }
            //if(empty($expyear)){
             //   array_push($errors, "Expiration year is Required");
            //}
            //if(empty($cvv)){
             //   array_push($errors, "CVV is Required");
            //}
            //if(count($errors == 0)){
               // $ecardnumber = md5($cardnumber);
               // $query = "INSERT INTO Payments ( `cname`, `cardnum`, `expmonth`, `expyear`, `cvv`, `baddress`, `astate`, `zip`, `city`) VALUES ('$cardname', '$ecardnumber', '$expmonth', '$expyear', '$cvv', '$address', '$state', '$zip', '$city')";
              //  $result = mysqli_query($conn, $query);
               // if($result){
                 //   echo "<script>alert('You have successfully made a payment.')</script>";
                 //   $id = $_SESSION["cust_id"];
                 //   $ip = getIpAdd();
                  //  $delete_books = "delete from cart where cust_id = '$id'";
                  //  $run_delete = mysqli_query($conn, $delete_books);
                  //  if($run_delete){
                   //     echo "<script>window.open('index.php','_self');</script>";
                   // }
              //  }
            
            //} 
           // else {
              //  echo "<script>alert('Errors found')</script>";
           // }
      // }
    ?>
</body>
</html>