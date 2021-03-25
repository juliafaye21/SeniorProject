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
                        echo $_SESSION['cust_id'];
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