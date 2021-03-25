<!-- This page is used for server side user input validation-->
<?php
require_once("includes/config.php");

//Declare variables for create user page to be used to put data inputted by user.
$c_name = "";
$c_email = "";
$c_phone = "";
$c_pass = "";
$c_confirmpass = "";
$username_err = "";
$emailAdd_err = "";
$phone_err = "";
$pass_err = "";
$ip = getIpAdd();

//Post form signup
if(isset($_POST['signup'])){

//Name verifaication
$regUsername = trim($_POST['name']);
//If name value from user is empty then set the username_err variable to error.
if(empty(trim($_POST['name']))){
    $username_err = "error";
}
//Use regular expression to check if the user name is in correct user input format is not it errors out.
elseif(!preg_match("/^[a-zA-Z-' ]*$/",$regUsername)){
    $username_err = "error";
}
else{
    //If the above checks pass then set the user name to variable $c_name
    $c_name = trim($_POST['name']); 
}

//email verifaication
$regEmail = trim($_POST['email']);
//Check if the email value from the form is empty if so set variable to error.
if(empty(trim($_POST['email']))){
    $emailAdd_err = "error";
}
elseif(!filter_var($regEmail, FILTER_VALIDATE_EMAIL)){
    $emailAdd_err = "error";
}
else{
$c_email = trim($_POST['email']);
}

//phone verification
$regPhone =  trim($_POST['phone']);
$ECPhone = str_replace([' ','.','-','(',')'],'',$regPhone);
if(empty(trim($_POST['phone']))){   
   $c_phone = NULL;
}
elseif(preg_match('/^[0-9]{10}+$/',$ECPhone)){
    
    $c_phone = $ECPhone;
}
else{
    $phone_err = "error";
}

//password verification
$regPasswd = trim($_POST['password']);
if(empty(trim($_POST['password']))){
    $pass_err = "error";
}
elseif(!preg_match("/^[A-Za-z]\w{6,14}$/",$regPasswd)){
    $pass_err = "error";
}
else{
$c_pass = trim($_POST['password']);
}


//delete safely
$sql2 = "SELECT email FROM customer WHERE email = ?";

if($stmt2 = mysqli_prepare($con, $sql2)){
   // Bind variables to the  prepared statement as parameters
  mysqli_stmt_bind_param($stmt2,"s",$param_email2);

   // Set parameters
  $param_email2 = $c_email;
   
   // Attempt to execute the prepared statement
   if(mysqli_stmt_execute($stmt2)){
    
       /* store result */
       mysqli_stmt_store_result($stmt2);
    
       if(mysqli_stmt_num_rows($stmt2) == 1){

         echo "1";

        } 
    else {
        //delete safely
        //Create a statment that will allow user to be added to the users table. 
        $query = "INSERT INTO customer (`cust_ip`, `name`, `email`, `password`, `phone`) VALUES (?,?,?,?,?)";
        //If the values are in error state than the mysqli_prepare staement will not be processed.
        if(empty($username_err) && empty($emailAdd_err) && empty($pass_err)){
            //Prepare statement is created for connection to the MySQL database.
            if($result = mysqli_prepare($con, $query)){
                //bind parameters to mysqli_stmt_bind_parameter. This is used so that MySQL injection statements cannot be used.
                mysqli_stmt_bind_param($result,"sssss",$param_ip,$param_name,$param_email,$param_password,$param_phone);
                //Set variables from bind statement to the user variables from the form.
                $param_ip = $ip;
                $param_name = $c_name;
                $param_email = $c_email;
                $param_password = password_hash($c_pass, PASSWORD_DEFAULT); // Creates a password hash
                $param_phone = $c_phone;
                echo $c_name;
                //Execute the statement
                if(mysqli_stmt_execute($result)){
                    //If the statement above is successful then the page will be redirected to the login.php page.
                    header("location: login1.php");
                } 
                else {
                    //If the executed statement failes then bringing back the below error on the page.
                    echo "Something went wrong. Please try again later.";
                }
                // Close statement
                mysqli_stmt_close($result);
            }
        }
    }
} 
else {
    //Used for error catching
    echo "Oops! Something went wrong. Please try again later.";
}
// Close statement
mysqli_stmt_close($stmt2);
}
}

//Login page variables
$email = $passwd = "";
$email_err = $password_err = "";
 
// Processing form data when form is submitted
if(isset($_POST['login'])){
 
    $regLoginEmail = trim($_POST["loginemail"]);
    //Check if login value from the form is empty.
    if(empty(trim($_POST["loginemail"]))){
        $email_err = "Error";
    }
    //Check if email is in the correct format email@emailprovider.com
    elseif(!filter_var($regLoginEmail, FILTER_VALIDATE_EMAIL)){
        $email_err = "error";
    }
    else{
        //If passes the above checks the users input from the form is set to variable $email. 
        $email = trim($_POST["loginemail"]);
    }

    $regPassLogin = trim($_POST["loginPassword"]);
    //Check if the login password from form is empty.
    if(empty(trim($_POST["loginPassword"]))){
        $password_err = "Error";
    }
    //Used regular expression to check if the password had letters from 6 to 14 letters in length.
    elseif(!preg_match("/^[A-Za-z]\w{6,14}$/",$regPassLogin)){
        $password_err = "error";
    }
    else{
        /**If the value from the form passes the above checks for password then the users input from the form is set 
         * to the variable $passwd.
         */
        $passwd = trim($_POST["loginPassword"]);
    }
 
    // Prepare a select statement to bring back customer id, email, and passwords
    if(empty($email_err) && (empty($password_err))){
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
    
    // Close conection
    mysqli_close($con);
   }
}
   ?>
