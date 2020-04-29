<?php
  session_start();
  if (isset($_SESSION['fname']) == true && $_SESSION['is_admin'] == 1) 
  {
    $user = '<a href ="logout.php" class = "w3-bar-item w3-button w3-padding-large">Log Out</a>';
  }
  else
  {
    header("location: home.php");
  }
  require_once("dbcontroller.php");
  $db_handle = new DBController();
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
              if($_GET["cloth_ID"] == $k)
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
<body bgcolor = "#F5DEB3" class="w3-content" style="max-width:1200px">
<nav class="w3-sidebar w3-bar-block w3-white w3-collapse" style="z-index:3;width:250px" id="mySidebar">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button "></i>
      <h3 class="w3-wide"><font size="3">Admin Database</font></h3>
      <h3 class="w3-wide"><font size="4"><strong>3SumCloset</strong></font></h3>
    </div>
    <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
    <a href="newcloth.php" class="w3-bar-item w3-button w3-padding-large w3-hover-white ">Add New </a>
	  <a href="changeprice.php" class="w3-bar-item w3-button w3-padding-large w3-hover-white ">Change Price</a>
	  <a href="changeqty.php" class="w3-bar-item w3-button w3-padding-large w3-hover-white ">Change Stock Qty</a>
    <a href="deletecloth.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Delete</a>
    </div>
  </nav>
<header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge">
  <div class="w3-top">
    <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium w3-large">
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
    <a href="manager.php" class="w3-bar-item w3-button w3-padding-large w3-white">Home</a>
  <?php echo $user ?>
</div>
  <h3 class="w3-wide"><p class="w3-center"><b></b>Welcome Back Manager</h3></p>
  <h3 class="w3-wide"><p class="w3-center"><font size="5"><strong>Nice to see you again !</strong></font></h3>
  <header class="w3-container w3-large w3-center">
  <div class="w3-bar w3-black w3-card w3-left-align w3-large">
  <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-red" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
  </div>
  <p> </p>
  </header>
  <div class="w3-display-container w3-container">
    <img src="product-images/header1.jpg" alt="Apex" style="width:100%"> </img>
    <div class="w3-display-topleft w3-text-white" style="padding:24px 48px">
      <h1 class="w3-hide-small"><font size="6"></h1>
    </div>
  </div>
  <div class="w3-container w3-text-grey" id="jeans">
    <p><b>Most Visit</b></p>
  </div>
  <?php
  $i = 0;
	$product_array = $db_handle->runQuery("SELECT * FROM clothes ORDER BY num_sold DESC");
  if (!empty($product_array)) 
  { 
    foreach($product_array as $key=>$value)
    {
    }
  }
	?>
<div class="w3-row">
    <div class="w3-col l3 s6">
      <div class="w3-container">
        <div class="w3-display-container">
        <form method="post" action="home.php?action=add&cloth_ID=<?php echo $product_array[0]["cloth_ID"]; ?>">
        <img src="<?php echo $product_array[0]["image"]; ?>" style="width:100%">
        </form>          
        <p><font size="3"><?php echo $product_array[0]["cloth_name"]; ?><br><b><font size="3"><?php echo "$".$product_array[0]["price"]; ?></b></p>
        </div>
      </div>
  <div class="w3-container">
    <div class="w3-display-container">
      <form method="post" action="home.php?action=add&cloth_ID=<?php echo $product_array[4]["cloth_ID"]; ?>">
        <img src="<?php echo $product_array[4]["image"]; ?>" style="width:100%">
        </form>          
        <p><font size="3"><?php echo $product_array[4]["cloth_name"]; ?><br><b><font size="3"><?php echo "$".$product_array[4]["price"]; ?></b></p>
      </div>
    </div>
  </div>
<div class="w3-col l3 s6">
    <div class="w3-container">
      <div class="w3-display-container">
      <form method="post" action="home.php?action=add&cloth_ID=<?php echo $product_array[1]["cloth_ID"]; ?>">
      <img src="<?php echo $product_array[1]["image"]; ?>" style="width:100%">
      </form>          
      <p><font size="3"><?php echo $product_array[1]["cloth_name"]; ?><br><b><font size="3"><?php echo "$".$product_array[1]["price"]; ?></b></p>
      </div>  
    </div>
    <div class="w3-container">
    <form method="post" action="home.php?action=add&cloth_ID=<?php echo $product_array[5]["cloth_ID"]; ?>">
  <img src="<?php echo $product_array[5]["image"]; ?>" style="width:100%">
    </form>          
      <p><font size="3"><?php echo $product_array[5]["cloth_name"]; ?><br><b><font size="3"><?php echo "$".$product_array[5]["price"]; ?></b></p>
    </div>
  </div>
  <div class="w3-col l3 s6">
    <div class="w3-container">
      <form method="post" action="home.php?action=add&cloth_ID=<?php echo $product_array[2]["cloth_ID"]; ?>">
    <img src="<?php echo $product_array[2]["image"]; ?>" style="width:100%">
    </form>          
    <p><font size="3"><?php echo $product_array[2]["cloth_name"]; ?><br><b><font size="3"><?php echo "$".$product_array[2]["price"]; ?></b></p>
      </div>
      <div class="w3-container">
      <div class="w3-display-container">
      <form method="post" action="home.php?action=add&cloth_ID=<?php echo $product_array[6]["cloth_ID"]; ?>">
    <img src="<?php echo $product_array[6]["image"]; ?>" style="width:100%">
    </form>          
      <p><font size="3"><?php echo $product_array[6]["cloth_name"]; ?><br><b><font size="3"><?php echo "$".$product_array[6]["price"]; ?></b></p>
        </div>
      </div>
    </div>
  <div class="w3-col l3 s6">
      <div class="w3-container">
      <form method="post" action="home.php?action=add&cloth_ID=<?php echo $product_array[3]["cloth_ID"]; ?>">
    <img src="<?php echo $product_array[3]["image"]; ?>" style="width:100%">
  </form>          
    <p><font size="3"><?php echo $product_array[3]["cloth_name"]; ?><br><b><font size="3"><?php echo "$".$product_array[3]["price"]; ?></b></p>
      </div>
      <div class="w3-container">
      <form method="post" action="home.php?action=add&cloth_ID=<?php echo $product_array[7]["cloth_ID"]; ?>">
    <img src="<?php echo $product_array[7]["image"]; ?>" style="width:100%">
    </form>          
    <p><font size="3"><?php echo $product_array[7]["cloth_name"]; ?><br><b><font size="3"><?php echo "$".$product_array[7]["price"]; ?></b></p>
      </div>
    </div>
  </div>
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