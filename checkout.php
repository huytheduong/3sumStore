<?php
  session_start();
  if (isset($_SESSION['fname']) == true)
  {
    if($_SESSION['is_admin'] == 1)
    {
      header("location: manager.php");
    }
    else
    {
    $user = '<a href ="logout.php" class = "w3-bar-item w3-button w3-padding-large">Log out</a>';
    $wishlist = "";
    }
  }
  else
  {
    $user = '<a href="login.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Log in</a>';
    $wishlist = '<a href ="newuser.php" class = "w3-bar-item w3-button w3-padding-large">New User</a>';
  }
  require_once "config.php";
  require_once("dbcontroller.php");
  if(!empty($_GET["action"])) 
  {
  switch($_GET["action"]) 
  {
      case "add":
          if(!empty($_POST["quantity"])) 
          {
              $productByCode = $db_handle->runQuery("SELECT * FROM clothes WHERE cloth_ID = '" . $_GET["cloth_ID"] . "'");
              $itemArray = array($productByCode[0]["cloth_ID"]=>array('cloth_name'=>$productByCode[0]["cloth_name"], 'cloth_ID'=>$productByCode[0]["cloth_ID"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"], 'image'=>$productByCode[0]["image"]));
              
              if(!empty($_SESSION["cart_item"])) 
              {
                  if(in_array($productByCode[0]["cloth_ID"],array_keys($_SESSION["cart_item"]))) 
                  {
                      foreach($_SESSION["cart_item"] as $k => $v) 
                      {
                              if($productByCode[0]["cloth_ID"] == $k) 
                              {
                                  if(empty($_SESSION["cart_item"][$k]["quantity"])) 
                                  {
                                      $_SESSION["cart_item"][$k]["quantity"] = 0;
                                  }
                                  $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                              }
                      }
                  } 
                  else 
                  {
                      $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
                  }
              } 
              else 
              {
                  $_SESSION["cart_item"] = $itemArray;
              }
          }
      break;

      case "remove":
          if(!empty($_SESSION["cart_item"])) {
              foreach($_SESSION["cart_item"] as $k => $v) 
              {
                      if($_GET["cloth_ID"] == $v["cloth_ID"])
                      unset($_SESSION["cart_item"][$k]);				
                      if(empty($_SESSION["cart_item"]))
                      unset($_SESSION["cart_item"]);
              }
          }
      break;
      case "empty":
          unset($_SESSION["cart_item"]);
      break;	
  }
}
  
?>


<!DOCTYPE html>
<html>
<title>cloth shop</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.w3-sidebar a {font-family: "Roboto", sans-serif}
body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif;}
</style>
<body bgcolor = "#98FB98" class="w3-content" style="max-width:1200px">
<nav class="w3-sidebar w3-bar-block w3-white w3-collapse" style="z-index:3;width:250px" id="mySidebar">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button "></i>
  <h3 class="w3-wide"><font size="3">Thank you for shoping with us</font></h3>
  <h3 class="w3-wide"><font size="3"><strong>3SumCloset</strong></font></h3>
</div>
  <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
    <p class="w3-bar-item">Shop By Category</p>
    <a href="jean.php" class="w3-bar-item w3-button">Jean</a>
    <a href="shirt.php" class="w3-bar-item w3-button">Shirt</a>
    <a href="shoe.php" class="w3-bar-item w3-button">Shoe & Jean</a>
  </div>
</nav>
<header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge">
  <div class="w3-top">
    <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium w3-large">
    <?php echo $wishlist ?>
    <?php echo $user ?>
  </div>
</div>
<div class="w3-bar-item w3-padding-24 w3-wide"></div>
<a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-24 w3-right" onclick="w3_open()"><i class="fa fa-bars"></i></a>
</header>
  <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>
    <div class="w3-main" style="margin-left:250px">
      <div class="w3-hide-large" style="margin-top:83px"></div>
      <header class="w3-container w3-xlarge">
      <div class="w3-bar w3-black w3-card w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-red" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
  <a href="home.php" class="w3-bar-item w3-button w3-padding-large w3-hover-white">Home</a>
<?php echo $wishlist ?>
<a href="cart.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Shopping Cart</a>
  <?php echo $user ?>
  </div>
</header>
  <div class="w3-container" id="jeans">
  <p><b><font size="6">Shopping Cart</font></b></p>
  <HEAD>
<TITLE>PHP Shopping Cart</TITLE>
<link href="style.css" type="text/css" rel="stylesheet" />
</HEAD>
<BODY>
<div id="shopping-cart">
<div class="w3-container">
<?php
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
?>	
<table class="tbl-cart" cellpadding="10" cellspacing="1">
<tbody>
<tr>
<th style="text-align:left;">Cloth Added</th>

<th style="text-align:right;" width="5%">Quantity</th>
<th style="text-align:right;" width="10%">Unit Price</th>
<th style="text-align:right;" width="10%">Price</th>
<th style="text-align:center;" width="5%">Delete</th>
</tr>	
<?php		
    foreach ($_SESSION["cart_item"] as $item){
        $item_price = $item["quantity"]*$item["price"];
		?>
				<tr>
				<td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /></td>
				<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
				<td  style="text-align:right;"><?php echo "$".$item["price"]; ?></td>
				<td  style="text-align:right;"><?php echo "$". number_format($item_price,2); ?></td>
				<td style="text-align:center;"><a href="checkout.php?action=remove&cloth_ID=<?php echo $item["cloth_ID"]; ?>" class="btnRemoveAction"><img src="trash.png" alt="Remove Item" /></a></td>
				</tr>
				<?php
				$total_quantity += $item["quantity"];
				$total_price += ($item["price"]*$item["quantity"]);
		}
		?>

<tr>
<td colspan="2" align="right">Total:</td>
<td align="right"><?php echo $total_quantity; ?></td>
<td align="right" colspan="2"><strong><?php echo "$".number_format($total_price, 2); ?></strong></td>

</tr>

</tbody>
</table>		
  <?php
} else {
?>
<div class="no-records">Shoping cart empty</div>
<?php 
}
?>
</div>
</div>
<?php
  $user_fname = $user_lname = $user_address = $credit_card_num = $current_cloth_qty = $order_confim = $cloth_name = $cloth_id = $current_sold = $user_email = $purchase_err = $user_num_clothes_purch = "";
 $user_fname_err = $user_lname_err = $user_address_err = $credit_card_num_err = $current_cloth_qty_err = $order_confim_err = $user_email_err ="";
 $user_in_DB = true;
   if($_SERVER["REQUEST_METHOD"] == "POST")
   {
       foreach($_SESSION["cart_item"] as $item)
       {
          if(empty(trim($_POST["user_email"])))
          {
           $user_email_err = "Please enter your email.";
          } 
          if(empty(trim($_POST["user_fname"])))
          {
              $user_fname_err = "Please enter your first name.";
          } 
          if(empty(trim($_POST["user_lname"])))
          {
              $user_lname_err = "Please enter your last name.";
          }
          if(empty(trim($_POST["user_address"])))
          {
              $user_address_err = "Please enter a address.";
          }
          if(empty(trim($_POST["credit_card"])) || $_POST["credit_card"] < 16)
          {
              $credit_card_num_err = "Please enter a credit card with length 16";
          }
       else
       {
           $cloth_id = $item["cloth_ID"];
           $cloth_name = $item["cloth_name"];
           $user_email = trim($_POST["user_email"]); 
          //fix here
          //$user_firstname = trim($_POST["user_fname"]);
          //$user_lastname = trim($_POST["user_lname"]);

           // Prepare a select statement
           $sql = "SELECT cloth_name, stock_qty, num_sold FROM clothes WHERE cloth_name = '$cloth_name' && cloth_ID = '$cloth_id'";
           $sql5 = "SELECT * FROM user WHERE user_email = '$user_email'";
           
           if($result = mysqli_query($link, $sql))
           {
               $rowcount = mysqli_num_rows($result);

               if($rowcount == 1)
               {
                    $getArray = $result->fetch_array();
                    $current_cloth_qty = $getArray["stock_qty"];         
                    $current_sold = $getArray["num_sold"];
                    if($result2 = mysqli_query($link, $sql5))
                    {
                      //echo "Got here result 2";
                        $rowcount2 = mysqli_num_rows($result2);
                        if($rowcount2 == 1)
                        {
                         // echo "Got here rowcount";
                          $getArray2 = $result2->fetch_array();
                          $user_num_clothes_purch = $getArray2["num_purchased_clothes"];
                         // echo $getArray2["num_purchased_games"];
                          
                        }
                        else
                        {
                          $user_in_DB = false;
                        }

                    }
                                        
                    if($current_cloth_qty == 0 || $current_cloth_qty < 0)
                    {
                            //echo "Sorry we are out of that cloth!";
                            $purchse_err = "Sorry we are out of that cloth!";
                            break;
                    }
               } 
               else
               {
                   $cloth_cloth_err = "Something went wrong, terribly wrong.";
               }
           } 
           else
           {
               echo "Oops! Something went wrong. Please try again later.";
           }
       }  
       if(empty($user_email_err) && empty($user_fname_err) && empty($user_lname_err) && empty($user_address_err) && empty($user_address_err))
       {
           
           //Prepare insert statement
           $sql = "UPDATE clothes SET stock_qty=?, num_sold = ? WHERE (cloth_ID = ? && cloth_name = ?)";

           //fix this to add more first name and the last name
           //delete 2 
           $sql2 = "INSERT INTO orders (user_email, user_fname, user_lname, cloth_ID, order_date, cloth_name) VALUES (?, ?, ?, ?, ?, ?)";
           //modified 
           $sql4 = "UPDATE user SET num_purchased_clothes	=? WHERE (user_email = ?)";

            //$sql3 = "UPDATE orders SET order_confirmation=? WHERE (user_email = ? && order_date = ?)";
           //$stmt = mysqli_prepare($link, $sql)
           if($stmt = mysqli_prepare($link, $sql))
           {
                    $stmt2 = mysqli_prepare($link, $sql2);
                    if($user_in_DB)
                    {
                      $stmt4 = mysqli_prepare($link, $sql4);
                    }
                    //$stmt4 = mysqli_prepare($link, $sql4);
                    date_default_timezone_set("America/New_York");
                    $order_date = date("Y-m-d H:i:s");
                    $user_email = trim($_POST["user_email"]);
                    $user_fname = ($_POST["user_fname"]);
                    $user_lname = ($_POST["user_lname"]); 

                    $num_sold = ($current_sold + $item["quantity"]);
                    $cloth_name = $item["cloth_name"];
                    $cloth_id = $item["cloth_ID"]; 
                    $cloth_qty = ($current_cloth_qty - $item["quantity"]);
                    
                    mysqli_stmt_bind_param($stmt, 'ssss', $cloth_qty,  $num_sold, $cloth_id, $cloth_name);
                    //delete the user_name and first name
                    mysqli_stmt_bind_param($stmt2, 'ssssss', $user_email, $user_fname, $user_lname, $cloth_id, $order_date, $cloth_name);

                    if($user_in_DB)
                    {
                      $update_user_num_clothes_purch = ($user_num_clothes_purch + $item["quantity"]);
                      mysqli_stmt_bind_param($stmt4, 'ss', $update_user_num_clothes_purch, $user_email);
                    }

                    
                    if($current_cloth_qty - $item["quantity"] < 0)
                    {
                        echo "Sorry we are out of that cloth! Your order has been canceled!";
                        $order_confim = "";
                        break;
                    }

                    if(mysqli_stmt_execute($stmt))
                    {
                        mysqli_stmt_execute($stmt2);
                        if($user_in_DB)
                        {
                          mysqli_stmt_execute($stmt4);
                        }                  
                        $order_confim .= $cloth_id;
                    }
                    else
                    {
                        printf("Error: %s.\n", mysqli_stmt_error($stmt));
                        printf("Error: %s.\n", mysqli_stmt_error($stmt2));
                        printf("Error: %s.\n", mysqli_stmt_error($stmt4));
                    }   

                }
           mysqli_stmt_close($stmt);
           mysqli_stmt_close($stmt2);
           if($user_in_DB)
           {
              mysqli_stmt_close($stmt4);
           }

        }

    }
       
}
if(empty($purchse_err))
{
    if(!empty($order_confim))
    {
        $sql3 = "UPDATE orders SET order_confirmation=? WHERE (user_email = ? && order_date = ?)";
        //fix here
        //$sql3 = "UPDATE orders SET order_confirmation=? WHERE (user_fname = ? && order_date = ?)";
        //$sql3 = "UPDATE orders SET order_confirmation=? WHERE (user_lname = ? && order_date = ?)";

        $stmt3 = mysqli_prepare($link, $sql3);
        //fix here
        $order_confim .= date("Ymd");
        $order_confim .= date("his");
        //fix here last name and first name
        mysqli_stmt_bind_param($stmt3, 'sss', $order_confim, $user_email, $order_date);

        mysqli_stmt_execute($stmt3);
        mysqli_stmt_close($stmt3);
        unset($_SESSION["cart_item"]);
        //echo "You Order confirmation is $order_confim";
    }
}
else
{
    echo "Looks like something went wrong with the order. Most likly you ordered a cloth we're out of stock, please check it again";
    $order_confim = "";
}
   mysqli_close($link);
?>
<center>
    <div>
    <p><b><font size="6">Check Out</font></b></p>
		</div>
		<form form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"> 
        <table border = "0" width = "300" height = "150">
        <tr> <td>Email</td>
            <td><input type="text" name="user_email" value="<?php echo $user_email; ?>">
            <?php echo $user_email_err; ?> </td> </tr>
        <tr> <td>First Name</td>
            <td><input type="text" name="user_fname" value="<?php echo $user_fname; ?>">
            <?php echo $user_fname_err; ?> </td> </tr>
        <tr> <td>Last Name </td>
            <td><input type="text" name="user_lname" value="<?php echo $user_lname; ?>"> 
            <?php echo $user_lname_err; ?> </td> </tr>
        <tr> <td>Address</td>
            <td><input type="text" name="user_address" value="<?php echo $user_address; ?>"> 
            <?php echo $user_address_err; ?></td> </tr>
        <tr> <td>Credit Card</td>
            <td><input type="text" name="credit_card" value="<?php echo $credit_card_num; ?>"> 
            <?php echo $credit_card_num_err; ?></td> </tr>
            </table>
        <input class="w3-button w3-black w3-margin-top" type = "submit" value = "SUBMIT ORDER">
        <input type="reset" class="w3-button w3-black w3-margin-top" value="RESET">
        <p> </p>
        </form>
	  </center> 
    </div>
    <center>
    <?php
    if(!empty($order_confim))
    {
    ?>
    <p><b><font size="6">Your Order Confirmation<?php echo $order_confim ?></font></b></p>
    <?php
    }else{
    ?>
    <p><b><font size="6"><?php echo $order_confim ?></font></b></p>
    </center> 
  </div>
  <?php
    }
    ?>
  <footer class="w3-container w3-black  w3-center w3-opacity">  
  <div class="w3-xlarge w3-padding-32">
  <h3 class="w3-margin w3-xlarge">Contact:</h3>
  <p><i class="fa fa-fw fa-phone"><font size="4"></i> 1234567890</p>
  <p><i class="fa fa-fw fa-envelope"><font size="4"></i> 3sumcloset@mail.com</p>
  <i class="fa fa-facebook-official fa-2x w3-hover-opacity"></i>
  <i class="fa fa-instagram fa-2x w3-hover-opacity"></i>
  <i class="fa fa-snapchat fa-2x w3-hover-opacity"></i>
 </div>
</footer>
<div class="w3-black w3-center w3-padding-24">Huy, Si and James</a>
</div>

<script>
function myAccFunc() {
  var x = document.getElementById("demoAcc");
  if (x.className.indexOf("w3-show") == -1) 
  {
    x.className += " w3-show";
  } 
  else 
  {
    x.className = x.className.replace(" w3-show", "");
  }
}
document.getElementById("myBtn").click();
function w3_open() 
{
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() 
{
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}
</script>

</body>
</html>