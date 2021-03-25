<!-- Some functions created by Mohamed Hasan https://github.com/priyesh18/book-store but modified by Julia George to make more secure.--> 
<!-- PHP documentation manual was used for mysqli https://www.php.net/manual/en/class.mysqli.php --> 
<?php

require_once("includes/config.php");

if(!function_exists(getIpAdd)){
function getIpAdd()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
}

//Function used to check if the book is already in the cart table. If it isn't in the cart table then the user input
//is added to the cart table. Function used off the index page.
if(!function_exists(cart)){
function cart(){
    if(isset($_GET['add_cart']))
    {
        global $con;
        $ip=getIpAdd();
        $id = $_SESSION["cust_id"];
        $book_id=$_GET['add_cart'];
        $check_product="SELECT bookid, cust_id FROM cart WHERE  cust_id=? AND bookid=?";
        //mysqli_prepare prepared the $check_product statement for execution.
        if($run_check=mysqli_prepare($con, $check_product)){
          //Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($run_check,'ss',$id,$book_id);
          //Attempt to execute the prepared statement
          mysqli_stmt_execute($run_check);
          //Store results
          mysqli_stmt_store_result($run_check);
          $num = mysqli_stmt_num_rows($run_check);
        if($num>0)
        {
          echo "Already added";
        }
        else {
          mysqli_stmt_close($run_check);
          $insert_cart="INSERT INTO cart(bookid, ip_add, cust_id) VALUES (?,?,?)";
          //mysqli_prepare prepares the $insert_cart statement for execution.
          if($run_cart = mysqli_prepare($con, $insert_cart)){
            //Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($run_cart,'sss',$book_id,$ip,$id);
            //Attempt to execute the prepared statement
            mysqli_stmt_execute($run_cart);
            mysqli_stmt_close($run_cart);
            echo "added";
          echo "<script>window.open('index.php','_self')</script>";
          }
        }
      }
    }
}
}
/** Function used to get values from cart and insert it into the history table. 
 * When moving from the payment page to successpay page.
 */
if(!function_exists(history)){
  function history(){
 
          global $con;
          $id = $_SESSION["cust_id"];
          $conf_number = confirmationNum();
          $myarray = array();
          $count = 0;
          $get_history = "SELECT bookid, ip_add, cust_id FROM cart WHERE  cust_id=?";
          //mysqli_prepare prepares the $get_history statement for execution.
          if($get_info = mysqli_prepare($con, $get_history)){
            //Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($get_info,'s',$id);
            //Attempt to execute the prepared statement
            mysqli_stmt_execute($get_info);
            mysqli_stmt_bind_result($get_info,$book_id,$ip_add,$cust_id);
            $count=0;
            while(mysqli_stmt_fetch($get_info)){
              $myarray[] = array($book_id, $ip_add, $cust_id);
              $count = $count + 1;
            }
            mysqli_stmt_close($get_info);
          }
     
          for($x = 0; $x < $count; $x++){
          $ip = $myarray[$x][1];
          $bookid = $myarray[$x][0];
          $status = "ordered";
          $array_id = $myarray[$x][2];
          $insert_history="INSERT INTO history(confirmation_number, bookid, ip_add, cust_id, order_status) VALUES (?,?,?,?,?)";
           //mysqli_prepare prepares the $insert_history statement for execution.
           if($run_history = mysqli_prepare($con, $insert_history)){
            //Bind variables to the prepared statement as parameters
            if(mysqli_stmt_bind_param($run_history,'iisss',$prep_confNum,$prep_bookid,$prep_ip,$prep_id,$prep_status)){
           }
           else{
             printf("Error: %s.\n",mysqli_stmt_error($run_history),E_USER_ERROR);
           }
             $prep_confNum = intval($conf_number);
              $prep_bookid = intval($bookid);
              $prep_ip = strval($ip);
              $prep_id = strval($id);
              $prep_status = strval($status);
            if(mysqli_stmt_execute($run_history)){
              echo "yay";
            }
            else{
             
              printf("Error: %s.\n",mysqli_stmt_error($run_history),E_USER_ERROR);
            }
           }
           else{
            printf("Error: %s.\n",mysqli_stmt_error($get_info));
            printf("Error: %s.\n",mysqli_stmt_error($run_history));
            printf("Error: %s.\n",mysqli_error($con));
            echo("Error description: " . mysqli_error($con));
         }
        }
          $delete_books = "DELETE FROM cart WHERE cust_id = ?";
          if($run_delete = mysqli_prepare($con, $delete_books)){
            mysqli_stmt_bind_param($run_delete,'s',$id);
            mysqli_stmt_execute($run_delete);
          }
         
          if($run_delete){
              echo "<script>window.open('successpay.php','_self');</script>";
           }
          }
  }
  // Function used on the seccesspay page to display orders where status is equal to ordered.
  if(!function_exists(getOrders)){
    function getOrders(){
   
            global $con;
       
            $id = $_SESSION["cust_id"];
            $total_price = 0;
            $stat = 'ordered';
            $get_history = "SELECT hs.bookid, bk.title, hs.confirmation_number, bk.price, hs.order_status FROM history as hs JOIN Books as bk ON hs.bookid = bk.book_id WHERE  hs.cust_id =? AND hs.order_status =?";
            if($get_info = mysqli_prepare($con, $get_history)){
                mysqli_stmt_bind_param($get_info,'ss',$id,$stat);
                mysqli_stmt_execute($get_info);
                mysqli_stmt_bind_result($get_info,$book_id,$bk_title,$conf_num,$price,$status);

            while(mysqli_stmt_fetch($get_info)){
           $total_price += $price;
           echo "
           <tr class='payment'>
           <td class='payment'>".$conf_num."</td>
           <td class='payment'>".$bk_title."</td>
           <td class='payment'>".$price."</td>
            <td class='payment'>".$status."</td>
            </tr>
            ";
        }
        echo "
        <tr class='payment'>
        <td class='payment'></td>
        <td class='payment'>Total Price</td>
        <td class='payment'>".$total_price."</td>
        </tr>";
      }
    }
  }
  //Function used on the successpay page to display orders where status is equal to completed. 
  if(!function_exists(getHistory)){
    function getHistory(){
            global $con;

            $id = $_SESSION["cust_id"];
            $status_bk = 'completed';
            $get_hs = "SELECT hs.bookid, hs.order_status, hs.confirmation_number, bk.title, bk.price FROM history as hs JOIN Books as bk ON hs.bookid = bk.book_id WHERE  hs.cust_id =? AND hs.order_status = ?";
           
            if($get_hsinfo = mysqli_prepare($con, $get_hs)){
              mysqli_stmt_bind_param($get_hsinfo,'ss',$id,$status_bk);
              mysqli_stmt_execute($get_hsinfo);
              mysqli_stmt_bind_result($get_hsinfo,$bookid,$status,$conf_numHS,$bk_title,$price);
              mysqli_stmt_fetch($get_hsinfo);
            }
            while(mysqli_stmt_fetch($get_hsinfo)){
          echo "<tr class='payment'>
          <td class='payment'>".$conf_numHS."</td>
          <td class='payment'>".$bk_title."</td>
          <td class='payment'>".$price."</td>
          <td class='payment'>".$status."</td>
          </tr>";
        }
        mysqli_stmt_close($get_hsinfo);
    }
  }
    //Function used to create a unique confirmation number
    if(!function_exists(confirmationNum)){
      function confirmationNum(){
        global $con;
        $id = 1;
        $newConfNum = 0;
        $get_confNumber = "SELECT Conf_Num FROM ConfNumber WHERE ConfNum_id=?";
        if($stmt = mysqli_prepare($con, $get_confNumber)){

          mysqli_stmt_bind_param($stmt,'s',$id);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_bind_result($stmt,$conf_Num);
          mysqli_stmt_fetch($stmt);
          mysqli_stmt_close($stmt);
        }  
      $newConfNum = $conf_Num + 1;
      $repl = "UPDATE ConfNumber SET Conf_Num=? WHERE ConfNum_id=?";
      if($stmt2 = mysqli_prepare($con,$repl)){
        mysqli_stmt_bind_param($stmt2,'is',$newConfNum,$id);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);
      }
     else{
        printf("Error: %s.\n",mysqli_stmt_error($stmt2));
        printf("Error: %s.\n",mysqli_error($con));

      }
      mysqli_close($stmt);
      mysqli_close($stmt2);
      return $newConfNum;
    }
    }
//Function used to count total items in cart.
if(!function_exists(total_items)){
function total_items(){
    global $con;
    $id = $_SESSION["cust_id"];
    $count = 0;
    if(isset($_GET['add_cart']))
    {

        $query = "SELECT bookid, ip_add, cust_id FROM cart WHERE cust_id=?";
        if($stmt = mysqli_prepare($con,$query)){
          mysqli_stmt_bind_param($stmt,'s',$id);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);
          $count=mysqli_stmt_num_rows($stmt);

        }
    }
    else {
        $query = "SELECT bookid, ip_add, cust_id FROM cart WHERE cust_id=?";
        if($stmt = mysqli_prepare($con,$query)){
          mysqli_stmt_bind_param($stmt,'s',$id);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);
          $count=mysqli_stmt_num_rows($stmt);
          }
    }
    echo $count;
}
}
//Function used to display items in cart on the cart page.
if(!function_exists(mycart)){
function mycart() {
  global $con;
  $id = $_SESSION["cust_id"];
    $count = 1;
    $total_price = 0;
  $get_cart = "SELECT ct.cust_id, bk.book_id, bk.title, bk.image, bk.price FROM Books bk LEFT JOIN cart ct ON bk.book_id = ct.bookid WHERE ct.cust_id=?";
  if($cart_items = mysqli_prepare($con,$get_cart)){
     mysqli_stmt_bind_param($cart_items,'s',$id);
     mysqli_stmt_execute($cart_items);
     mysqli_stmt_bind_result($cart_items,$cust_id,$book_id,$title,$image,$price);
   
  while(mysqli_stmt_fetch($cart_items)){
  
    $single_price = $price;
    $total_price += $single_price;  
    $bk_title = $title;
    $bookid = $book_id;
    echo "<tr>
                <td scope='row'><h3>".$count++."</h3></td>
                 <td scope='row' class='td-actions'>
                   
                   <h3> <div class='checkbox'>
                        <label>
                      <input type='checkbox'  name='remove[]' value='".$book_id."'>
                         
                     </label>
                       </div></h3>
                     
                </td>
                <td><img src='assets/images/".$image."' width='60px' height='80px'></td>
                <td><h3>".$bk_title."</h3></td>
                <td><h3>1</h3></td>
                <td><h3>&#36;".$single_price."</h3></td>  
            </tr>";
   
  }
    echo "<tr><td colspan='6' align='right'><h3>Total=&#36;".$total_price."</h3></td></tr>" ;
 
}
else{
  printf("Error: %s.\n",mysqli_stmt_error($cart_items));
  printf("Error: %s.\n",mysqli_error($con));
}
}

}
//Function used to display name from category table. 
if(!function_exists(getcats)){
function getcats(){
  global $con;

  $query4="SELECT `name` from category";
  if($result=mysqli_prepare($con, $query4)){
    mysqli_stmt_execute($result);
    mysqli_stmt_bind_result($result,$name);
  while(mysqli_stmt_fetch($result))
  {
    echo "<li role=\"presentation\"><a href=\"index.php?category=".$name."\">".$name."</a></li>";
  }
   mysqli_stmt_close($result);
}
}
}
//Function used to get author from books table. 
if(!function_exists(getauths)){
function getauths(){
  global $con;

  $query3="SELECT DISTINCT author FROM Books";
  if($result=mysqli_prepare($con, $query3)){
    mysqli_stmt_execute($result);
    mysqli_stmt_bind_result($result,$author);
  while(mysqli_stmt_fetch($result))
  {
    echo "<li role=\"presentation\"><a href=\"#".$author."\">".$author."</a></li>";
  }
  mysqli_stmt_close($result);
}
}
}
//Function used to get books and display them from the Books table. 
if(!function_exists(getbooks)){
function getbooks(){
  global $con;
    if(!isset($_GET['category'])){
  $query="SELECT `book_id`, `author`, `keywords`, `title`, `price`, `image`, `description`, `category` from `Books`";
  if($result=mysqli_prepare($con, $query)){
    mysqli_stmt_execute($result);
    mysqli_stmt_bind_result($result,$book_id,$author,$keywords,$title,$price,$image,$description,$category);

  while(mysqli_stmt_fetch($result))
  {
   
    echo "<div class='col-lg-4 col-md-6'>
                            <div class='card'>
                                <img class='card-img' height='200px' width='100px' src='assets/images/".$image."'>
                                <span class='content-card'>
                                    <h6>".$title."</h6>
                                    <h7>".$author."</h7>
                                </span>
                                <a href='index.php?add_cart=".$book_id."'><button class='buybtn btn btn-warning btn-round btn-sm'>
                  Add <i class='material-icons'>add_shopping_cart</i>
                </button></a>
                                <button class='knowbtn btn btn-warning btn-round btn-sm' data-toggle='modal' data-target='#".$book_id."'>
                  Know More
                </button>";
                               
           //code for modal
        echo "<div class='modal fade' id='".$book_id."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                  <div class='modal-dialog'>
                    <div class='modal-content'>
                      <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                        <h4 class='modal-title' id='myModalLabel'>".$title."</h4>
                      </div>
                      <div class='modal-body'>
                      <h4><p align='right'>&#36;".$price."</p></h4>".
                          $description
                      ."</div>
                     
                    </div>
                  </div>
                </div>
                               
              </div>
                        </div>";    //the last two </div> are from previous echo.
  }
    }
  }
  }
}

//Function used to search the Books table by Category that user selects and display it on the page.
if(!function_exists(get_bycat)){
function get_bycat(){
  global $con;
  if(isset($_GET['category'])){
    $cat_id= $_GET['category'];
    $get_cat_pro = "SELECT `book_id`, `author`, `keywords`, `title`, `price`, `image`, `description`, `category` from `Books` WHERE `category` LIKE ?";
    if($run_cat_pro=mysqli_prepare($con,$get_cat_pro)){
      mysqli_stmt_bind_param($run_cat_pro,'s',$cat_id);
      mysqli_stmt_execute($run_cat_pro);
      mysqli_stmt_bind_result($run_cat_pro,$book_id,$author,$keywords,$title,$price,$image,$description,$category);
      mysqli_stmt_store_result($run_cat_pro);
    $count_cat = mysqli_stmt_num_rows($run_cat_pro);
    if($count_cat==0){
      echo "<h2>No books found</h2>";
    }
    while(mysqli_stmt_fetch($run_cat_pro))
  {
    echo "<div class='col-lg-4 col-md-6'>
                            <div class='card'>
                                <img class='card-img' height='200px' width='100px' src='assets/images/".$image."'>
                                <span class='content-card'>
                                    <h6>".$title."</h6>
                                    <h7>".$author."</h7>
                                </span>
                                <a href='index.php?add_cart=".$book_id."'><button class='buybtn btn btn-warning btn-round btn-sm'>
                  Add <i class='material-icons'>add_shopping_cart</i>
                </button></a>
                                <button class='knowbtn btn btn-warning btn-round btn-sm' data-toggle='modal' data-target='#".$book_id."'>
                  Know More
                </button>";
                               
           //code for modal
        echo "<div class='modal fade' id='".$book_id."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                  <div class='modal-dialog'>
                    <div class='modal-content'>
                      <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                        <h4 class='modal-title' id='myModalLabel'>".$title."</h4>
                      </div>
                      <div class='modal-body'>
                      <h4><p align='right'>&#36;".$price."</p></h4>".
                          $description
                      ."</div>
                     
                    </div>
                  </div>
                </div>
                               
              </div>
                        </div>";    //the last two </div> are from previous echo.
  }
    }
  }
  }
}
?>
