<?php
include("function/functions.php");
require_once("includes/config.php");


$email = trim($_POST["loginemail"]);
$password = trim($_POST["loginPassword"]);

// Prepare a select statement
$sql = "SELECT cust_id, email, password FROM customer WHERE email= ?";

if($stmt = mysqli_prepare($con, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $param_email);
    
    // Set parameters
    $param_email = $email;
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        // Store result
        mysqli_stmt_store_result($stmt);
        
        // Check if username exists, if yes then verify password
        if(mysqli_stmt_num_rows($stmt) == 1){   
            echo 1;                 
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
            if(mysqli_stmt_fetch($stmt)){
                if(password_verify($password, $hashed_password)){
                    // Password is correct
                   echo 2;
                } else{
                    // Display an error message if password is not valid
                   echo 3;
                }
            }
        } else{
            // Display an error message if username doesn't exist
            echo 4;
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

}




?>