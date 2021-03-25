<!-- This page is used by cart page to keep session alive. -->
<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login1.php");
    exit;
}
    require_once("includes/config.php");
    include("payment.php");

?>