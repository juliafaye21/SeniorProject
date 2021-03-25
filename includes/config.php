<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
//ini_set ('error_reporting', E_ALL);
//ini_set ('display_errors','1');
//error_reporting (E_ALL|E_STRICT);

//Set variables to values for connection to database.
$Servername = '127.0.0.1';
$userName = 'ekbaker';
$pass = 'X5j13$#eCM1cG@Kdc';
$db2 = 'ecom';
 
/* Attempt to connect to MySQL database */
$con = mysqli_init();

/*verify server cert is set to true*/
mysqli_options($con,MYSQLI_OPT_SSL_VERIFY_SERVER_CERT,true);

/*set the cert to be used because this is local host we are using ca cert*/   
$con->ssl_set(NULL,NULL,'/etc/mysql/ca.pem',NULL,NULL);
/*Uses real connect to connect to the database and forcing SSL connection on port 3306*/
$db = mysqli_real_connect($con,$Servername,$userName,$pass,$db2,3306,NULL,MYSQLI_CLIENT_SSL);

/*checks if the db is connected or not.. if it cannot connect it will die and return an error*/
if(!$db)
{
    die ("Could not connect");
}
?>