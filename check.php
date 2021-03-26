<?php
require_once("includes/config.php");
include("function/functions.php");

//Declare variables for email, name
$c_email2 = "";
$c_name = trim($_POST['name']); 
$c_email = $_POST['email'];

//Get phone value and check if it is empty and if it is set to null else set value to form value user inputs for phone. Not used currently. 
//if(empty(trim($_POST['phone']))){
 //$c_phone = NULL;
//}else{
    //$c_phone = trim($_POST['phone']);
//}

//Set password variable to password user sets.
$c_pass = trim($_POST['password']);

//Check if the email has already been used.
$sql2 = "SELECT email FROM customer WHERE email = ?";
        
    if($stmt2 = mysqli_prepare($con, $sql2)){
     // Bind variables to the prepared statement as parameters
         mysqli_stmt_bind_param($stmt2,"s",$param_email2);
    // Set parameters
         $param_email2 = $c_email;
    // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt2)){
        /* store result */
            mysqli_stmt_store_result($stmt2);
        if(mysqli_stmt_num_rows($stmt2) == 1){
            echo 1;
 
       } else{
           echo 0;
    }
}
    }
    ?>
