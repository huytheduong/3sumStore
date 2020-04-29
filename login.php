<?php
session_start();
$error=''; 
if (isset($_POST['login'])) {
if (empty($_POST['user_email']) || empty($_POST['user_pass'])) 
{
}
else
{
$username=$_POST['user_email'];
$password=$_POST['user_pass'];
$conn = mysqli_connect("localhost","root","","cloth_store");
$query = "SELECT user_email, user_fname, user_pass, is_admin FROM user WHERE user_pass = '".$_POST["user_pass"]."' AND user_email ='".$_POST["user_email"]."'";

if ($result = mysqli_query($conn, $query));
  {
	 	$getArray = $result->fetch_array();
    $fname = $getArray['user_fname'];
    $email = $getArray['user_email'];
    $is_admin = $getArray['is_admin'];
    
  $rowcount = mysqli_num_rows($result);
    if ($rowcount) 
    {	
        $_SESSION['fname'] = $fname;
        $_SESSION['user_email'] = $email;
        $_SESSION['is_admin'] = $is_admin;
        $_SESSION['cart']=array();
      	header("location: home.php");
    } 
    else 
    {
        $error = "Username or Password is invalid";
        echo "Username or Password is invalid, Please re-enter your information !";
        mysqli_free_result($result);
    }
    mysqli_close($conn);
    }
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
<body bgcolor = "#EE82EE" class="w3-content" style="max-width:1200px">
<nav class="w3-sidebar w3-bar-block w3-white w3-collapse" style="z-index:3;width:250px" id="mySidebar">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button "></i>
    <h3 class="w3-wide"><font size="3">Your Best Place to Shop Clothes</font></h3>
    <h3 class="w3-wide"><font size="4"><strong>3SumCloset</strong></font></h3>
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
    <a href="login.php" class="w3-bar-item w3-button w3-padding-large">Log in</a>
      <a href="newuser.php" class="w3-bar-item w3-button w3-padding-large">New User</a>
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
    <a href="login.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Log in</a>
    <a href="newuser.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">New User</a>
</div>
  <h3 class="w3-wide"><p class="w3-center"><b></b></h3></p>
  </header>
  <div class="w3-container w3-center" id="jeans">
    <p><b><font size="6">3Sum Member Login</font></b></p>
    </div>
<div class="w3-row-padding  w3-container">
  <div class="w3-content">
    <div class="w3-center">
    <center>
		<form action = "<?=$_SERVER['PHP_SELF']?>" method = "post">
		<table border = "0" width="300" height = "150">
		<tr><td>Your Email:</td>
    <td><input type = "text" name = "user_email">
		</td></tr>       
		<tr><td>Your Password:</td>
    <td><input type = "password" name = "user_pass">
		</td></tr>
		<tr><td colspan="5" align = "center"> <input class="w3-button w3-black w3-margin-top" type = "submit" name = "login" value = "Login">
		</td></tr>
		</table>
        </form>
  </div>
		</center>
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
  } else 
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
