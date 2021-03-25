<!-- Navigation taken from Mohamed Hasan https://github.com/priyesh18/book-store-->
<!-- Payment format and CSS taken from w3schools https://www.w3schools.com/howto/howto_css_checkout_form.asp-->
<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login1.php");
    exit;
}
//PHP section on this page is used for server side validation. landing/js/payment.js is used for client side user input validation.
include("function/functions.php");
require_once("includes/config.php");

//Empty variables used to assign values later in the php code the values the user inputs into the form.
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
$book_id = "";
$ip_add = "";
$cust_id = "";
$order_status = "";

$errors[] = '';
if(isset($_POST['submit']))
{
    $regAddress = $_POST['address'];
    //Checks to see if the address field is empty in the form. 
    if(empty($_POST['address'])){
        $address_err = "Address is required";
    }
    /**Uses regular expressions to check that upper case, lower case letters, and period or dash can be used.
     * This checks if the address meets a certain criteria lower case letters, upper case letters, and period or dash.
     */
    elseif(!preg_match("/^[a-zA-Z0-9' .\-]+$/i", $regAddress)){
        $address_err = "error";
    }
    else{
        //If above passes if statements then address the user inputted into the form is set to the $address variable.
        $address = $_POST['address'];
        $address_err = "";
    }

    $regCity = $_POST['city'];
    //Check if city field is empty
    if(empty($_POST['city'])){
        $city_err = "City is required";
    }
    //Check if the city has lower case and upper case letter.
    elseif(!preg_match("/^[a-zA-Z-' ]*$/", $regCity)){
        $city_err = "error";
    }
    //Else assign the city value to $city variable
    else{
        //If variable passes the above two if checks then the value is assigned to a variable.
        $city = $_POST['city'];
        $city_err = "";
    }

    $regState = $_POST['state'];
    //Check if the value is empty
    if(empty($_POST['state'])){
        $state_err = "State is requred";
    }
    //Use regular expression to see if the value has only upper and lower case letters.
    elseif(!preg_match("/^[a-zA-Z-' ]*$/", $regState)){
        $state_err = "error";
    }
    //If value passes the above two if checks then the value is assigned to a variable.
    else{
        $state = $_POST['state'];
       $state_err = "";
    }

    $regZip = $_POST['zip'];
    //Check if the value is empty.
    if(empty($_POST['zip'])){
        $zip_err = "Zip is requred";
    }
    //Use regular expression to see of the value has 5 numbers and optional 4 numbers.
    elseif(!preg_match("/^[0-9{5}(-[0-9]{4}]?$/", $regZip)){
        $zip = $_POST['zip'];
        $zip_err = "";
    }
    //If value passes the above if checks then the value is assigned to a variable.
    else{
        $zip_err = "error";
    }

    $regCardName = $_POST['cardname'];
    //Check if the value is empty.
    if(empty($_POST['cardname'])){
        $cardname_err = "Name for card is requred";
    }
    //Use upper case and lower case letters only.
    elseif(!preg_match("/^[a-zA-Z-' ]*$/", $regCardName)){
        $cardname_err = "error";
    }
    //If value passes the above two if checks then the value is assigned to a variable. 
    else{
        $cardname = $_POST['cardname'];
        $cardname_err = "";
    }

    $regCardNumber = $_POST['cardnumber'];
    //Checks if the value is empty.
    if(empty($_POST['cardnumber'])){
        $cardnumber_err = "Card number is requred";
    }
    //Set 16 numbers
    elseif(!preg_match("/^[0-9]{16}$/", $regCardNumber)){
        $cardnumber_err = "error";
    }
    //If value passes the above two if checks then the value is assigned to a variable.
    else{
        $cardnumber = $_POST['cardnumber'];
        $cardnumber_err = "";
    }

    $regExpMonth = $_POST['expmonth'];
    //Check if the value it empty.
    if(empty($_POST['expmonth'])){
        $expmonth_err = "Expiration month is requred";
    }
    //Only has numbers 1 through 12
    elseif(!preg_match("/^([0-9]|01[012])$/", $regExpMonth)){
        $expmonth_err = "error";
    }
    //If value passes the above two if checks then the value is assigned to a variable. 
    else{
        $expmonth = $_POST['expmonth'];
        $expmonth_err = "";
    }

    $regExpyear = $_POST['expyear'];
    //Check if the value is empty.
    if(empty($_POST['expyear'])){
        $expyear_err = "Expiration year is requred";
    }
    //Has only 2 numbers in length/
    elseif(!preg_match("/^[0-9]{2}$/", $regExpyear)){
        $expyear_err = "error";
    }
    //If value passes the above two if checks then the value is assigned to a variable.
    else{
        $expyear = $_POST['expyear'];
        $expyear_err = "";
    }

    $regCvv = $cvv = $_POST['cvv'];
    //Check if the value is empty.
    if(empty($_POST['cvv'])){
        $cvv_err = "CVV is requred";
    }
    //Only use 3 length in numbers.
    elseif(!preg_match("/^[0-9]{3}$/", $regCvv)){
        $cvv_err = "error";
    }
    //If value passes the above two if checks then the value is assigned a variable.
    else{
        $cvv = $_POST['cvv'];
        $cvv_err = "";
    }

    //If any of the values are not empty then the below if statement will not execute.
    if(empty($address_err) && empty($city_err) && empty($state_err) && empty($zip_err) && empty($cardname_err) && empty($cardnumber_err) && empty($expmonth_err) && empty($expyear_err) && empty($cvv_err)){
        //Build query statement and set the query ti variable named $query
        $query = "INSERT INTO `Payments`(`cust_id`, `cname`, `cardnum`, `expmonth`, `expyear`, `cvv`, `baddress`, `astate`, `zip`, `city`) VALUES (?,?,?,?,?,?,?,?,?,?)";
        /**Prepares the MySQL query, and returns a statement handle to be used for further operations in the statement. 
         * The query must consist of a single SQL statement.
        */
        if($stmt = mysqli_prepare($con,$query)){
            //Bind variables for the parameter markers in the SQL statement that was passed to mysqli_prepare().
            mysqli_stmt_bind_param($stmt,"ssssssssss", $param_id, $param_cname, $param_ecard, $param_expmonth, $param_expyear, $param_cvv, $param_address, $param_state, $param_zip, $param_city);
            //Pass variable user assigned variables to variables used for mysqli_stmt_bind_param. 
            $param_id = intval($id);
            $param_cname = $cardname;
            $param_ecard = md5($cardnumber);
            $param_expmonth = intval($expmonth);
            $param_expyear = intval($expyear);
            $param_cvv = intval($cvv);
            $param_address = $address;
            $param_state = $state;
            $param_zip = intval($zip);
            $param_city = $city;
            //Execute a prepared statement.
            if(mysqli_stmt_execute($stmt)){
              
                history();
            }
         else{
         
            die( 'stmt error: '.mysqli_stmt_error($stmt) );
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
    <script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"> </script> 
    <script src="landing/js/payment.js"></script>
    
</head>

<body style="margin-top:150px">


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
                    <li><a href="successpay.php">Order Status</a></li>
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
                                    <input type="text" id="ccnum" name="cardnumber" class="cardnumber" placeholder="1111222233334444">
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
                                           <input type="text" id="expyear" name="expyear" class="expyear" placeholder="21">
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
                            <input type="submit" name = "submit" value="Continue to checkout" class="btn">
                        </form>
                    </div>
                </div>
            </div>
    </body>
</html>