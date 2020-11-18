<?php
require_once("config.php");

$c_name = "";
$c_email = "";
$c_phone = "";
$c_pass = "";
$c_confirmpass = "";
$username_err = "";
//$password_err = "";
//$confirm_password_error = ""
$emailAdd_err = "";
$phone_err = "";
$pass_err = "";
$ip = getIpAdd();

if(isset($_POST['signup'])){

//Name verifaication
$regUsername = trim($_POST['name']);
if(empty(trim($_POST['name']))){
    $username_err = "error";
}
//!preg_match("/^[a-zA-Z-' ]*$/",$ECRelationshipKind)
elseif(!preg_match("/^[a-zA-Z-' ]*$/",$regUsername)){
    $username_err = "error";
    echo "<script>alert('userName')</script>";
}
else{
$c_name = trim($_POST['name']); 
}

//email verifaication
$regEmail = trim($_POST['email']);
if(empty(trim($_POST['email']))){
    $emailAdd_err = "error";
}
elseif(!filter_var($regEmail, FILTER_VALIDATE_EMAIL)){
    $emailAdd_err = "error";
    echo "<script>alert('eamil')</script>";
}
else{
$c_email = trim($_POST['email']);
}

//phone verification
$regPhone =  trim($_POST['phone']);
//$ECPhoneNumber2 = trim($_POST['ECPhoneNumber']);
$ECPhone = str_replace([' ','.','-','(',')'],'',$regPhone);
if(empty(trim($_POST['phone']))){
   $c_phone = NULL;
}
elseif(preg_match('/^[0-9]{10}+$/',$ECPhone)){
    
    $c_phone = $ECPhone;
    echo "<script>alert('".$c_phone."')</script>";
}
else{
    $phone_err = "error";
    echo "<script>alert('phone')</script>";
}

//password verification
$regPasswd = trim($_POST['password']);
if(empty(trim($_POST['password']))){
    $pass_err = "error";
}
elseif(!preg_match("/^[A-Za-z]\w{6,14}$/",$regPasswd)){
    $pass_err = "error";
   echo "<script>alert('password')</script>";
}
else{
$c_pass = trim($_POST['password']);
}


//delete safely
$sql2 = "SELECT email FROM customer WHERE email = ?";

if($stmt2 = mysqli_prepare($conn, $sql2)){
    //alert("prepare");
   // Bind variables to the  prepared statement as parameters
  mysqli_stmt_bind_param($stmt2,"s",$param_email2);
 // $count = msqli_num_rows($stmt2);
   // Set parameters
  $param_email2 = $c_email;
 // alert($c_email);
   
   // Attempt to execute the prepared statement
   if(mysqli_stmt_execute($stmt2)){
       //alert("usernameExecute");
       /* store result */
       mysqli_stmt_store_result($stmt2);
       //$count = 
       if(mysqli_stmt_num_rows($stmt2) == 1){
           //alert("numberorws");
         echo "1";

      } else{
         //echo "0";
      

//delete safely
 
 $query = "INSERT INTO customer (`cust_ip`, `name`, `email`, `password`, `phone`) VALUES (?,?,?,?,?)";
 if(empty($username_err) && empty($emailAdd_err) && empty($pass_err)){
 if($result = mysqli_prepare($conn, $query)){
    // alert("result");
  mysqli_stmt_bind_param($result,"sssss",$param_ip,$param_name,$param_email,$param_password,$param_phone);
     $param_ip = $ip;
     $param_name = $c_name;
     $param_email = $c_email;
     $param_password = password_hash($c_pass, PASSWORD_DEFAULT); // Creates a password hash
     $param_phone = $c_phone;

     //echo $c_name;
     if(mysqli_stmt_execute($result)){
         //alert("resultExecute");
        // Redirect to login page
        //echo "This has been submitted";
        //header("location: login.php");
       
    } else{
       // alert("went wrong");
        echo "Something went wrong. Please try again later at database level.";
    }

    // Close statement
    mysqli_stmt_close($result);
}
 }
                 
                    //$response['status'] = false;
                   // $response['msg'] =  "This user email is already taken";
                    //$response['status'] = true;
                    //$email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
           // echo json_encode($response);
            // Close statement
            mysqli_stmt_close($stmt2);
        }
 }


$email = $passwd = "";
$email_err = $password_err = "";
 
// Processing form data when form is submitted
if(isset($_POST['login'])){
 
        $regLoginEmail = trim($_POST["loginemail"]);
        if(empty(trim($_POST["loginemail"]))){
           $email_err = "Error";
        }
        elseif(!filter_var($regLoginEmail, FILTER_VALIDATE_EMAIL)){
            $email_err = "error";
            echo "<script>alert('eamil')</script>";
        }
        else{
        $email = trim($_POST["loginemail"]);
        }

        $regPassLogin = trim($_POST["loginPassword"]);
        if(empty(trim($_POST["loginPassword"]))){
            $password_err = "Error";
        }
        elseif(!preg_match("/^[A-Za-z]\w{6,14}$/",$regPassLogin)){
            $password_err = "error";
           echo "<script>alert('password')</script>";
        }
        else{
        $passwd = trim($_POST["loginPassword"]);
        }
 
        // Prepare a select statement
        if(empty($email_err) && (empty($password_err))){
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
}
   ?>