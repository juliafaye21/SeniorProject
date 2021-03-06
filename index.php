<!-- CSS and format was taken from Mohamed Hasan https://github.com/priyesh18/book-store and editted by Julia George. --> 
<?php 
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login1.php");
    exit;
}
/**Inlclude the function page that has the functions total_items(), get_carts(), carts(), getbooks(), and getbycat() required
 * for this page.
 */
include("function/functions.php");
include("includes/config.php");

?>
<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8" />


    <title>Julia's BookStore</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    <!-- CSS Files -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/material-kit.css" rel="stylesheet" />
    <link href="assets/css/styles.css" rel="stylesheet" />
</head>

<body data-spy="scroll" data-target="#myScrollspy" data-offset="15">

    <!-- Navbar will come here  -->

    <nav class="navbar navbar-fixed-top" role="navigation" id="topnav">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
    		</button>
                <a class="navbar-brand" href="#">Julia's BookStore</a>

            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php">Home</a></li>
                    <li><a href="successpay.php">Order Status</a></li>
                    <?php 
                    
                   
                    if(!isset($_SESSION['email'])){
                        echo "<li><a href='login1.php'>Login</a></li>";
                    }
                    else 
                    {
                        echo "<li><a href='logout.php'>Logout</a></li>";
                    }
                     if(isset($_SESSION['email'])){
                        $sess=$_SESSION['email'];
                        echo "<li><a>Hi ".$_SESSION['email']." !</a></li>";
                    }
                    else {
                        echo "<li><a>Guest</a></li>";
                    }
                    ?>

                    <li><a href="cart.php">Go to Cart<span class="badge"><?php total_items(); ?></span></a></li>

                </ul>
            </div>
        </div>
    </nav>



    <!-- end navbar -->
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="carousel slide multi-item-carousel" id="theCarousel">
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="col-xs-4" id="bk1">
                                <!-- jpg images, titles, and ook description declared below. -->
                                <img src="./assets/images/twilight.jpg">
                                <div class="c-content "><b>Twilight</b><br> by Stephanie Meyer<br><br>
                                    <p>High school student Bella Swan moves from Arizona to Washington.</br>
                                    She meets a handsome but mysterious teen whose eyes seem to peer directly into her soul. Edward is a vampire and bella enters into a dangerous roamnce.
                                </div>

                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-4" id="bk2">
                                <!-- jpg images, titles, and ook description declared below. -->
                                <img src="./assets/images/fiftyshades.jpg">
                                <div class="c-content "><b>Fifty Shades of Grey</b><br> by E L James<br><br> When literature student Anastasia Steele goes to interview young entrepreneur Christian Grey, she encounters a man who is beautiful, brilliant, and intimidating.
                                </div>

                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-4" id="bk3">
                                <!-- jpg images, titles, and ook description declared below. -->
                                <img src="assets/images/it.jpg">
                                <div class="c-content "><b>IT</b><br> by Stephen King<br><br>7 children and one evil entity. <br> Following the experinces of these children as they are terrorized by their fears.
                                </div>

                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-4" id="bk4">
                                <!-- jpg images, titles, and ook description declared below. -->
                                <img src="assets/images/dinosaursbeforedark.jpg">
                                <div class="c-content "><b>Magic Tree House: Dinosaurs Before Dark</b><br> by Mary Pope Osborne<br><br> Two children and a treehouse.<br>An adventure of a lifetime. 
                                </div>

                            </div>
                        </div>


                    </div>
                    <!-- This controls the left and right sliding console affect on the end of the images displayed. -->
                    <a class="left carousel-control" href="#theCarousel" data-slide="prev"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></a>
                    <a class="right carousel-control" href="#theCarousel" data-slide="next"></a>
                </div>
            </div>
        </div>
    </div>
    <!--carousel end-->



    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-2 col-md-2" id="myScrollspy">
                <ul data-offset-top="225" data-spy="affix" class="nav nav-pills  nav-stacked">
                    <li role="presentation"><a href="index.php">All books</a></li>
                    <!-- Calls the getcats() function that searches through the name of category by name from category table. -->
                    <?php getcats();?>

                </ul>
            </div>
            <div class="col-lg-10 col-md-10" id="mainarea">



                <div class="container-fluid">
                    <!-- This addes orders to the cart table -->
                    <?php cart(); ?>
                    <!-- Adding books -->
                    <div class="row">
                        <!-- Gets books from the books table. -->
                        <?php getbooks();?>
                        <!-- Gets books by category from books table.--> 
                        <?php get_bycat();?>


                    </div>


                </div>

            </div>
        </div>
    </div>


</body>

<!--   Core JS Files   -->
<script src="assets/js/jquery.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/js/material.min.js"></script>

<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="assets/js/nouislider.min.js" type="text/javascript"></script>

<!--  Plugin for the Datepicker, full documentation here: http://www.eyecon.ro/bootstrap-datepicker/ -->
<script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>

<!-- Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc -->
<script src="assets/js/material-kit.js" type="text/javascript"></script>
<script src="assets/js/carousel.js" type="text/javascript"></script>
<script src="assets/js/myscripts.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

</html>