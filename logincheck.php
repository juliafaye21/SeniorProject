<?php
    require_once("includes/config.php");
    include("function/functions.php");
    $c_email4 = "";
    $c_email4_err = "";

    if(empty($_POST['loginemail'])){
    
        $c_email4_err = "error";
    }
    else{
    $c_email4 = $_POST['loginemail'];
    }
    if($empty($c_email4_err)){
    $sql2 = "SELECT email FROM customer WHERE email = ?";
    
        
    if($stmt2 = mysqli_prepare($con, $sql2)){
     // Bind variables to the prepared statement as parameters
         mysqli_stmt_bind_param($stmt2, "s", $param_email);
    // Set parameters
         $param_email = $c_email4;
    // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt2)){
        /* store result */
            mysqli_stmt_store_result($stmt2);
             
        if(mysqli_stmt_num_rows($stmt2) == 0){
            echo 4;
 
       } else{
           echo 5;
       }
    }
}
    }
?>