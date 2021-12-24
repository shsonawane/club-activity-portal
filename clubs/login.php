<?php 
$error = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
  include '../sql.php';
  $clubid = $_POST["clubid"];
  $password = $_POST["password"];
  $type = $_POST["type"];
  if(getLogin($clubid,$password,$type)){
      session_start();
      $_SESSION['clubid'] = $clubid;
      $token = bin2hex(openssl_random_pseudo_bytes(16));
      $_SESSION['token'] = $token;
      header('Location: dashboard.php?clubid='.$clubid.'&token='.$token);
  }else{
    $error = "<br>Invalid Input. Try Again....";
  }
  $conn->close();
}
?>
<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title>Login</title>

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
				<img src="https://www.jobsatmuj.in/img/logo_black.svg" width="50" height="50" class="d-inline-block align-top" alt="">
				<img src="https://www.jobsatmuj.in/img/name.svg" width="180" height="45" class="d-inline-block align-top" alt="">
		</div>
		<div>
		 <a class="button block black hover-black large m6 l6 s6 col" style="width: 50%; cursor: auto;">Clubs</a> 
		 <a href="../hod/login.php" class="button block light-grey hover-black large m6 l6 s6 col" style="width: 50%;">HOD</a>
		</div>
	</div>
<div class="bgimg display-container text-white">
  <div class="display-middle" style="width:100%;">
    <div class="padding-64 small center">
    <div class="row-padding">
      <div class="col s1 m3 l4">
<br>
      </div>

      <div class="light-grey padding-large padding-32  col s10 m6 l4"  style="margin-top: 50px;">
              <h3>Club Login</h3>
        <form action=""  method="post">
          <p><input class="input border medium" type="text" placeholder="Club ID" name="clubid" required></p>
		  <p>
		  <select class="input border medium" name="type" required>
		  <option value="" >Select Club Type</option>
			<option value="club">University Club</option>
			<option value="Dept">Department Club</option>
			<option value="ccs">CCS</option>
		  </select>
		  </p>
          <p><input class="input border medium" type="password" placeholder="Password" name="password" required></p>
          <button type="submit" class="button block black large">Login</button>
        </form>
        <b id="err" class="text-red medium"><?php echo $error;?></b>
        <br>
      </div>

      <div class="col s1 m3 l4 justify">
        <br>
      </div>
    </div>
  </div>
  </div>
  <footer class="bottom container padding-16 dark-grey center">
 	<div>Devloped By Shubham Sonawane, Guided By Dr. Vijaypal Singh Dhaka, Dept. of Computer And Communication</div>
</footer>
</div>


</body>
</html>