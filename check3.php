<?php
include("config.php");

// Processing form data when form is submitted
if(isset($_POST['login'])){
 
   
    
    $email = trim($_POST["loginemail"]);
    $passwd = trim($_POST["loginPassword"]);

    // Prepare a select statement
    $sql = "SELECT cust_id, email, password FROM customer WHERE email= ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
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
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                if(mysqli_stmt_fetch($stmt)){
                    if(password_verify($passwd, $hashed_password)){
                        // Password is correct, so start a new session
                        session_start();
                        
                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["cust_id"] = $id;
                        $_SESSION["email"] = $email;                            
                        
                        // Redirect user to welcome page
                        header("location: index.php");
                    } else{
                        // Display an error message if password is not valid
                        $password_err = "The password you entered was not valid.";
                    }
                }
            } else{
                // Display an error message if username doesn't exist
                $username_err = "No account found with that username.";
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

// Close connection
mysqli_close($conn);
//if(isset($_REQUEST['register'])) { 
    //$param_id2 = $_REQUEST['id'];
    //echo $param_id2;
   // header("location: register.php");
//} 
}

//sign in
          // if(isset($_POST['login'])){
            //  $email= $_POST['loginemail'];
             //  $pass = $_POST['loginPassword'];
              // $sel_c="select * from customer where password='$pass' AND email='$email'";
              // $run_c=mysqli_query($conn,$sel_c);
             //  $check_customer=mysqli_num_rows($run_c);
               //    if($check_customer==0)
                //{
                  //   echo "<script>alert('Password or Username is incorrect')</script>";
               // }
                ///$ip = getIpAdd();
               // $get_items="SELECT * FROM `cart` WHERE `ip_add`='$ip'";
                 //$run=mysqli_query($conn, $get_items);
                    //$check_cart = mysqli_num_rows($run);
                    //if($check_customer>0 AND $check_cart==0){
                        
                      //  $_SESSION['email']=$email;
                       // echo "<script>alert('Login Successful')</script>";
                       // echo "<script>window.open('index.php','_self')</script>";
                  //  }
                  //  if($check_customer>0 AND $check_cart>0){
                   //       $_SESSION['email']=$email;
                     //    echo "<script>alert('Login Successful')</script>";
                     //    echo "<script>window.open('checkout.php','_self')</script>";
            
            
       // }
    
          // }
         // Define variables and initialize with empty values


?>
