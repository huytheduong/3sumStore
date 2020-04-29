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
          if(!empty($_SESSION["cart_item"])) 
          {
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
<body bgcolor = "#66CDAA" class="w3-content" style="max-width:1200px">
<nav class="w3-sidebar w3-bar-block w3-white w3-collapse" style="z-index:3;width:250px" id="mySidebar">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button "></i>
    <h3 class="w3-wide"><font size="3">Thank you for shoping with us</font></h3>
    <h3 class="w3-wide"><font size="4"><strong>3SumCloset</strong></font></h3>
	</div>
  <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
    <p class="w3-bar-item"><font size="4">Shop By Category</p>
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
    <a href="cart.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Bag</a>
  <?php echo $user ?>
</div>
    
    
</header>
<div class="w3-container" id="jeans">
<p><b><font size="6">Shopping Cart</font></b></p>

<HEAD>
<TITLE>Simple PHP Shopping Cart</TITLE>
<link href="style.css" type="text/css" rel="stylesheet" />
</HEAD>
<BODY>
<div id="shopping-cart">
<div class="w3-container">
<?php
if(isset($_SESSION["cart_item"]))
{
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
    foreach ($_SESSION["cart_item"] as $item)
    {
    $item_price = $item["quantity"]*$item["price"];
		?>
			<tr>
				<td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /></td>
				<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
				<td  style="text-align:right;"><?php echo "$".$item["price"]; ?></td>
				<td  style="text-align:right;"><?php echo "$". number_format($item_price,2); ?></td>
				<td style="text-align:center;"><a href="cart.php?action=remove&cloth_ID=<?php echo $item["cloth_ID"]; ?>" class="btnRemoveAction"><img src="trash.png" alt="Remove Item" /></a></td>
				</tr>
				<?php
				$total_quantity += $item["quantity"];
				$total_price += ($item["price"]*$item["quantity"]);
		}
		?>
<tr>
<td colspan="2" align="right">Total Price:</td>
<td align="right"><?php echo $total_quantity; ?></td>
<td align="right" colspan="2"><strong><?php echo "$".number_format($total_price, 2); ?></strong></td>
</tr>
<td><td><td><td><td><td align="right"><a href="checkout.php" class="w3-button w3-black w3-margin-top">Check Out</a></td></td></td>
</tbody>
</table>		
  <?php
} 
else 
{
?>
<div class="no-records">Your Shoping Cart Now Empty</div>
<?php 
}
?>
</div>
</div>
  <footer class="w3-container w3-black  w3-center w3-opacity">  
  <div class="w3-xlarge w3-padding-32">
  <h3 class="w3-margin w3-xlarge">Contact:</h3>
  <p><i class="fa fa-fw fa-phone"><font size="4"></i> 1234567890</p>
  <p><i class="fa fa-fw fa-envelope"><font size="4"></i>3SumCloset@mail.com</p>
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
  } else {
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