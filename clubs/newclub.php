
<?php

include '../sql.php';

$evt = "";
$token = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
	if(empty($_POST['evt']) || empty($_POST['token']))
		die;
	
	$evt = $_POST['evt'];
	$token = $_POST['token'];
}else{
	if(empty($_GET['evt']) ||  empty($_GET['token']))
		die;
	
	$evt = $_GET['evt'];
	$token = $_GET['token'];
}

    $stmt = $conn->prepare("SELECT * FROM newevent where idnewevent=? and clubid is null;");
    $stmt->bind_param("s", $evt);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
	
if($row['token']!=$token){
	http_response_code(404);
	echo "NOT FOUND";
	die;
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>New Event</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../resource/w3.css">
<link rel="stylesheet" href="../resource/bar-graph.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.js"></script>
<style>
h1,h2,h3,h4,h5,h6 {font-family: "Raleway", sans-serif}
body{font-family: "Montserrat", sans-serif;}
.bold{font-weight: bold;}
pre {
	display: block;
	font-family: arial;
    white-space: pre-wrap;   
    white-space: -moz-pre-wrap;
    white-space: -pre-wrap;  
    white-space: -o-pre-wrap;  
    word-wrap: break-word; 
}
.primary,.hover-primary:hover{color:#000!important;background-color:#f9cb3e!important}
.text-primary,.hover-text-primary:hover{color:#f9cb3e!important}
.border-primary,.hover-border-primary:hover{border-color:#f9cb3e!important}
</style>
<script>
function onSubmit(){
	frm = new Date(document.getElementById("from").value);
	to = new Date(document.getElementById("to").value);
	//alert(frm+" "+to);
	if(frm <= to){
			return true;
	}else{
		alert("Check Your Dates Again!!")
	}
	return false;
}
</script>

</head>
<body>
<!-- Header -->
<div class="primary container center"> 
    <div class="padding">
				<img src="../resource/logo_black.svg" width="60" height="60" class="d-inline-block align-top" alt="">
				<img src="../resource/name.svg" width="180" height="45" class="d-inline-block align-top" alt="">
	</div>
  <h6>Club Activity Portal</h6>
</div >


  <br>
  	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$web = "";
		if(!empty($_POST["web"])){
			$web = $_POST["web"];
		}
		$result = createAccount( $_POST["clubid"], $_POST["name"], $_POST["dept"],$_POST["president"], $_POST["vice"], $_POST["about"], $_POST["phone"], $_POST["email"], $web, $_POST["pass"], $_POST["type"]); 
		if($result == 0){
			$stmt = $conn->prepare("INSERT INTO `notify` (`title`, `desc`, `for`, `newclub`) VALUES ( ?, 'New Club Application', 'admin', ?);");
			$stmt->bind_param("ss",$_POST["name"],$_POST["clubid"]);
			$stmt->execute();
			
			$stmt = $conn->prepare("DELETE FROM `newevent` WHERE `idnewevent`= ? ;");
			$stmt->bind_param("s", $evt);
			$stmt->execute();
				
			echo "<h2 class='center text-green'>Account Successfully Created. Account Will Be Active Once Verified.</h2><br>";
			die;
		}else{
			echo "<h2 class='center text-red'>Error, Try Again.</h2><br>";
		}
	}
	?>
   <div class="row-padding padding-left container margin-left margin-right white" style="height: auto;">
   	<div class="container white section">
    <h4><b>New Club Application</b></h4>
	<form action="" onSubmit="return onSubmit();" method="post">
	   <input class="input border" type="hidden" value="<?=$evt?>" name="evt" required>
	    <input class="input border" type="hidden" value="<?=$token?>" name="token" required>
        <div class="col 112 margin-bottom">
          <label>Club Login Id</label>
          <input class="input border" type="text" value="" name="clubid" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Club Type</label>
          <select class="input border medium" name="type" required>
			<option>Select Club Type</option>
			<option value="club">University Club</option>
			<option value="dept">Department Club</option>
			<option value="ccs">CCS</option>
		  </select>
        </div>
		<div class="col 112 margin-bottom">
          <label>Club Name</label>
          <input class="input border" type="text" name="name" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Department</label>
          <select class="input border medium" name="dept" required>
		  <option>Selec Dept.</option>
			<option>Computer and Communication (SCIT)</option>
			<option>IT (SCIT)</option>
			<option>Computer Science (SCIT)</option>
			<option>Other</option>
		  </select>
        </div>
		<div class="col 112 margin-bottom">
          <label>President Name</label>
          <input class="input border" type="text" value="" name="president" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Vice President Name</label>
          <input class="input border" type="text" value="" name="vice" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Contact Number</label>
          <input class="input border" type="text" placeholder="Example: 9876543210" value="" pattern="[1-9]{1}[0-9]{9}" name="phone" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Email ID</label>
          <input class="input border" type="email" placeholder="Example: abc@xyz.com" value=""  title="abc@xyz.com" name="email" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Website (Optional)</label>
          <input class="input border" pattern="^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9](?:\.[a-zA-Z]{2,})+$" placeholder="Example: www.abc.com" title="www.abc.com" value="" name="web">
        </div>
		<div class="col 112 margin-bottom">
          <label>About Club</label>
          <textarea class="input border" rows="10" name="about" required></textarea>
        </div>
		<div class="col 112 margin-bottom">
          <label>Password</label>
          <input id="pass" class="input border" placeholder="6 characters minimum" type="password" value="" pattern=".{6,}" title="8 characters minimum" name="pass" required>
        </div>
		<div class="col 112 margin-bottom">
          <label  class="col l10 m8">Confirm Password</label> <strong id="err_pass" hidden class="text-red col l2 m4">Password Doesn't Match!</strong>
          <input id="cpass" class="input border" type="password" value="" name="cpass" required>
        </div>
          <button type="submit" class="button black margin-bottom"><i class="fa fa-paper-plane margin-right"></i>Submit</button>
    </form>
    </div>
   </div>
 <br>
 <script>
  function onSubmit(){
    var pass= document.getElementById("pass").value;
    var cpass= document.getElementById("cpass").value;
    if(pass == cpass){
      document.getElementById("err_pass").hidden = true;
      return true;
    }else{
      document.getElementById("err_pass").hidden = false;
      return false;
    }
  }
</script>
<?php include 'foot.php';?>
</body>
</html>