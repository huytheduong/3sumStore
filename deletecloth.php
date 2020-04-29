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

  require_once "config.php";

  $cloth_id = $cloth_name = "";
  $cloth_id_err = $cloth_name_err = "";
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
      //ask user to enter the cloth name and cloth id
        if(empty(trim($_POST["cloth_name"])))
        {
            $cloth_name_err = "Please enter a cloth name.";
        } 
        if(empty(trim($_POST["cloth_id"])))
        {
            $cloth_id_err = "Please enter a cloth id.";
        }
        else
        {
            $sql = "SELECT cloth_name FROM clothes WHERE cloth_name = ? && cloth_ID = ?";
            
            if($stmt = mysqli_prepare($link, $sql))
            {
                mysqli_stmt_bind_param($stmt, "ss", $param_cloth_name, $param_cloth_id);
                $param_cloth_id = trim($_POST["cloth_id"]);
                $param_cloth_name = trim($_POST["cloth_name"]);
                if(mysqli_stmt_execute($stmt))
                {
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) == 1)
                    {
                        $cloth_name = trim($_POST["cloth_name"]);
                    } 
                    //if the cloth id not exist then pop out something
                    else
                    {
                        $cloth_name_err = "Something went wrong, terribly wrong.";
                    }
                } 
                else
                {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            mysqli_stmt_close($stmt);
        }
        if(empty($cloth_name_err) && empty($cloth_id_err))
        {
            $sql = "DELETE FROM clothes WHERE (cloth_ID = ? && cloth_name = ?)";
            if($stmt = mysqli_prepare($link, $sql))
            {
                mysqli_stmt_bind_param($stmt, 'ss', $cloth_id, $cloth_name);
                //delete the cloth_name user enter
                $cloth_name = trim($_POST["cloth_name"]);
                //delete the cloth id from user enter
                $cloth_id = trim($_POST["cloth_id"]);               
                if(!mysqli_stmt_execute($stmt))
                {
                    echo "You didn't delete the cloth!";
                }
                else
                {
                    echo "Deleted cloth!";
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
<body  bgcolor = "#E6E6FA" class="w3-content" style="max-width:1200px">
<nav class="w3-sidebar w3-bar-block w3-white w3-collapse" style="z-index:3;width:250px" id="mySidebar">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button "></i>
    <h3 class="w3-wide"><font size="3">Admin Database</font></h3>
    <h3 class="w3-wide"><font size="4"><strong>3SumCloset</strong></font></h3>
	 </div>
  <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
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
  <div class="w3-bar w3-black w3-card w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-red" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
  </div>
	 <p> </p>
  </header>
  </header>
  <div class="w3-container w3-center" id="jeans">
    <p><b><font size="6">Delete</font></b></p>
  </div>
 <div class="w3-row-padding  w3-container">
  <div class="w3-content">
    <div class="w3-center">
	<center>
      <div>
		</div>
		<form form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"> 
		<table border = "0" width = "300" height = "150">
		<tr> <td>Cloth ID</td>
        <td><input type="text" name="cloth_id" value="<?php echo $cloth_id; ?>">
        <?php echo $cloth_id_err; ?> </td> </tr>
		<tr> <td>Cloth Name </td>
        <td><input type="text" name="cloth_name" value="<?php echo $cloth_name; ?>"> 
        <?php echo $cloth_name_err; ?> </td> </tr>
		</table>
		<input class="w3-button w3-black w3-margin-top" type = "submit" value = "Delete">
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
	<div class="w3-black w3-center w3-padding-24">Huy, Si and James</a>
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