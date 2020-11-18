<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login1.php");
    exit;
}
    include("config.php");
    include("payment.php");

?>