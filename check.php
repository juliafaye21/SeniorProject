<?php
require_once("config.php");
include("function/functions.php");
$c_email2 = "";
//$email = "";
//$response = array();
//$count = "";

//$c_email2 = mysqli_real_escape_string($conn,$_POST['email']);
$c_name = trim($_POST['name']); 
$c_email = $_POST['email'];
if(empty(trim($_POST['phone']))){
 $c_phone = NULL;
}else{
    $c_phone = trim($_POST['phone']);
}
$c_pass = trim($_POST['password']);

$sql2 = "SELECT email FROM customer WHERE email = ?";
        
    if($stmt2 = mysqli_prepare($conn, $sql2)){
     // Bind variables to the prepared statement as parameters
         mysqli_stmt_bind_param($stmt2, "s", $param_email2);
    // $count = msqli_num_rows($stmt2);
    // Set parameters
         $param_email2 = $c_email;
        // $response['msg'] = $param_email2;
    
    // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt2)){
        /* store result */
            mysqli_stmt_store_result($stmt2);
        //$count = 
        if(mysqli_stmt_num_rows($stmt2) == 1){
            echo 1;
 
       } else{
           echo 0;
    }
}
    }
    ?>