<?php
  session_start();
  if (isset($_SESSION['fname']) == true && ($_SESSION['is_admin']) == 1) 
  {
    $user = '<a href ="logout.php" class = "w3-bar-item w3-button w3-padding-large">Log Out</a>';
  }
  else
  {
    header("location: home.php");
  }
  require_once "config.php";
  $cloth_name = $cloth_type = $cloth_year = $cloth_developer = $cloth_price = $cloth_qty = $cloth_image = "";
  $cloth_name_err = $cloth_type_err = $cloth_year_err = $cloth_developer_err = $cloth_price_err = $cloth_qty_err = $cloth_image_err = "";
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    //same as add new user so ask user to enter
   if(empty(trim($_POST["cloth_name"]))){
          $cloth_name_err = "Please enter a cloth name.";
      } 
      else
      {
          $sql = "SELECT cloth_name FROM clothes WHERE cloth_name = ?";
          if($stmt = mysqli_prepare($link, $sql))
          {
              mysqli_stmt_bind_param($stmt, "s", $param_cloth_name);
              $param_cloth_name = trim($_POST["cloth_name"]);
              if(mysqli_stmt_execute($stmt))
              {
                  mysqli_stmt_store_result($stmt);
                  //if the cloth name already exsit then just pop the word
                  if(mysqli_stmt_num_rows($stmt) == 1)
                  {
                      $cloth_name_err = "This cloth looks like it already exists, please double check.";
                  } 
                  else
                  {
                      $cloth_name = trim($_POST["cloth_name"]);
                  }
              } 
              else
              {
                  echo "Oops! Something went wrong. Please try again later.";
              }
          }
          mysqli_stmt_close($stmt);
      }
      //then the rest will ask user to enter all information
      if(empty(trim($_POST["cloth_type"])))
      {
          $cloth_type_err = "Please enter a cloth type.";
      }
      if(empty(trim($_POST["cloth_year"])))
      {
          $cloth_year_err = "Please enter year released.";
      }
      if(empty(trim($_POST["cloth_developer"])))
      {
          $cloth_developer_err = "Please enter a cloth developer.";
      }        
      if(empty(trim($_POST["cloth_price"])))
      {
          $cloth_price_err = "Please enter a cloth price.";
      }
      if(empty(trim($_POST["cloth_qty"])))
      {
          $cloth_qty_err = "Please enter the quantity.";
      }
      if(empty(trim($_POST["image"])))
      {
          $cloth_image_err = "Please enter image for cloth.";
      } 
      if(empty($cloth_name_err) && empty($cloth_type_err) && empty($cloth_year_err && empty($cloth_developer_err) && empty($cloth_price_err) && empty($cloth_qty_err) && empty($cloth_image_err)))
      {
        //after that will insert all of user information into the database
          $sql = "INSERT INTO clothes (cloth_name, cloth_type, year_released, developer, price, stock_qty, image, num_sold) VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
           
          if($stmt = mysqli_prepare($link, $sql))
          {
              mysqli_stmt_bind_param($stmt, 'sssssss', $cloth_name, $cloth_type, $cloth_year, $cloth_developer, $cloth_price, $cloth_qty, $cloth_image);
              $cloth_name = trim($_POST["cloth_name"]);
              $cloth_type = trim($_POST["cloth_type"]);
              $cloth_year = $_POST["cloth_year"];
              $cloth_developer = trim($_POST["cloth_developer"]);
              $cloth_price = trim($_POST["cloth_price"]);
              $cloth_qty = trim($_POST["cloth_qty"]);
              $cloth_image = trim($_POST["image"]);
              
              if(mysqli_stmt_execute($stmt))
              {
                  echo "Success! Added cloth to Database.";
              } 
              else
              {
                  echo "You failed!";
              }
          }
          mysqli_stmt_close($stmt);
      }
      mysqli_close($link);
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
<body bgcolor = "#FFE4C4" class="w3-content" style="max-width:1200px">
<nav class="w3-sidebar w3-bar-block w3-white w3-collapse" style="z-index:3;width:250px" id="mySidebar">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button "></i>
    <h3 class="w3-wide"><font size="3">Admin Database</font></h3>
    <h3 class="w3-wide"><font size="4"><strong>3SumCloset</strong></font></h3>
	 </div>
  <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
  <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-red" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
  <a href="newcloth.php" class="w3-bar-item w3-button w3-padding-large w3-hover-white ">Add New </a>
	<a href="changeprice.php" class="w3-bar-item w3-button w3-padding-large w3-hover-white ">Change Price</a>
	<a href="changeqty.php" class="w3-bar-item w3-button w3-padding-large w3-hover-white ">Change Stock</a>
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
    <a href="home.php" class="w3-bar-item w3-button w3-padding-large w3-hover-white">Home</a>
  <?php echo $user ?>
</div>
  <h3 class="w3-wide"><p class="w3-center"><b></b></h3></p>
    <header class="w3-container w3-large w3-center">
	<p><font size="5"><b></b></font></p>
<div class="w3-bar w3-black w3-card w3-left-align w3-large">
  </div>
<p> </p>
  </header>
  </header>
  <div class="w3-container w3-center" id="jeans">
    <p><b><font size="6">Add New</font></b></p>
  </div>
 <div class="w3-row-padding  w3-container">
  <div class="w3-content">
    <div class="w3-center">
	<center>
      <div>
		</div>
		<form form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"> 
		<table border = "0" width = "300" height = "150">
		<tr> <td>Name</td>
    <td><input type="text" name="cloth_name" value="<?php echo $cloth_name; ?>"> 
    <?php echo $cloth_name_err; ?></td> </tr>
		<p> </p>
		<tr> <td>Type </td>
    <td><input type="text" name="cloth_type" value="<?php echo $cloth_type; ?>"> 
    <?php echo $cloth_type_err; ?></td> </tr>
		<tr> <td>Year released</td>
    <td><input type="date" name="cloth_year" value="<?php echo $cloth_year; ?>"> 
    <?php echo $cloth_year_err; ?></td> </tr>
		<tr> <td>Designer</td>
    <td><input type="text" name="cloth_developer" value="<?php echo $cloth_developer; ?>"> 
    <?php echo $cloth_developer_err; ?></td> </tr>	
		<tr> <td>Price</td>
    <td><input type="text" name="cloth_price" value="<?php echo $cloth_price; ?>"> 
    <?php echo $cloth_price_err; ?></td> </tr>
		<tr> <td>Quantity </td>
    <td><input type="text" name="cloth_qty" value="<?php echo $cloth_qty; ?>"> 
    <?php echo $cloth_qty_err; ?></td> </tr>
    <tr> <td>Image </td>
    <td><input type="text" name="image" value="<?php echo $cloth_image; ?>"> 
    <?php echo $cloth_image_err; ?></td> </tr>
		</table>
    <input class="w3-button w3-black w3-margin-top" type = "submit" value = "Add">
    <input type="reset" class="w3-button w3-black w3-margin-top" value="Reset">
		<p> </p>
		</form>
	</center>  
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
<div class="w3-black w3-center w3-padding-24">Huy, Si and Jame</a>
</div>
<script>
function myAccFunc() {
  var x = document.getElementById("demoAcc");
  if (x.className.indexOf("w3-show") == -1) {
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