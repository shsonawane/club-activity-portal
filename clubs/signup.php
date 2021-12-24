<?php 
$error = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
  include '../sql.php';
  $result = createAccount( $_POST["clubid"], $_POST["clubname"], $_POST["dept"], $_POST["phone"], $_POST["email"], $_POST["password"], $_POST["type"]); 
  if($result == 0){
	$stmt = $conn->prepare("INSERT INTO `notify` (`title`, `desc`, `for`, `newclub`) VALUES ( ?, 'New Club Application', 'admin', ?);");
	$stmt->bind_param("ss",$_POST["clubname"],$_POST["clubid"]);
	$stmt->execute();
    include 'signup_done.php';
    die;
  }else if($result == 1062){
    //echo "Clubid Already Exist";
    $error = "Club Id '".$_POST["clubid"]."' Already Exist";
  }else {
    $error = "Error Occured ! Try Again...";
  }
  $conn->close();
}
?>
<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title>Sign Up</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../resource/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
h1,h2,h3,h4,h5,h6,body {font-family: "Raleway", sans-serif}
body, html {height: 100%}
.bgimg {
    background-image: url('../resource/background.jpg');
    min-height: 100%;
    background-position: center;
    background-size: cover;
}
.bgcolor {
background-color: rgba(255, 255, 255, 0.6)
}
</style>
</head>
<body>
	<div class="top" style="background-color: #f9cb3e">
		<div class="padding center large">
				<img src="../resource/logo_black.svg" width="50" height="50" class="d-inline-block align-top" alt="">
				<img src="../resource/name.svg" width="180" height="45" class="d-inline-block align-top" alt="">
		</div>
	</div>
<div class="bgimg display-container text-white">
  <div class="display-middle" style="width:100%;">
    <div class="padding-64 small center">
    <div class="row-padding">
      <div class="col s1 m3 l4">
<br>
      </div>

      <div class="light-grey padding-large col s10 m6 l4" style="margin-top: 70px;">
              <h3>Register</h3>
        <form action="" onsubmit="return validateForm()" method="post">
          <p><input class="input border medium" type="text" placeholder="Club ID" name="clubid" required></p>
		  <p><input class="input border medium" type="text" placeholder="Club Name" name="clubname" required></p>
		  <p><input class="input border medium" type="text" placeholder="Department" name="dept" required></p>
		  <p>
		  <select class="input border medium" name="type" required>
		  <option>Select Type</option>
			<option value="club">Club</option>
			<option value="Dept">Department Club</option>
			<option value="ccs">CCS</option>
		  </select>
		  </p>
		  <p><input class="input border medium" type="email" placeholder="Email ID" name="email" required></p>
		  <p><input class="input border medium" type="text" placeholder="Phone No." max="10" min="10" name="phone" required></p>
      <p><input id="pass" class="input border medium" type="password" placeholder="Password" name="password" required></p>
		  <p><input id="cpass" class="input border medium" type="password" placeholder="Confirm Password" required></p>
          <button type="submit" class="button block black large">Register</button>
        </form>
        <b id="err" class="text-red medium"><?=$error?></b>
   </div>

      <div class="col s1 m3 l4 justify">
        <br>
      </div>
    </div>
  </div>
  </div>
</div>
    <footer class="container padding-16 dark-grey center">
 	<div>Devloped By Shubham Sonawane, Guided By Dr. Vijaypal Singh Dhaka, Dept. of Computer And Communication</div>
</footer>

<script>
  function validateForm(){
    var pass= document.getElementById("pass").value;
    var cpass= document.getElementById("cpass").value;
    if(pass == cpass){
      return true;
    }else{
      document.getElementById("err").innerHTML = "Password confirmation failed! ";
      return false;
    }
  }
</script>
</body>
</html>