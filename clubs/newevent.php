
<?php

include '../sql.php';

$evt = "";
$club = "";
$token = "";

if(empty($_GET['club']))

if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(empty($_POST['evt']) || empty($_POST['club']) || empty($_POST['token']))
			die;
	
	$evt = $_POST['evt'];
	$club = $_POST['club'];
	$token = $_POST['token'];
}else{
	if(empty($_GET['evt']) || empty($_GET['club']) || empty($_GET['token']))
			die;
	
	$evt = $_GET['evt'];
	$club = $_GET['club'];
	$token = $_GET['token'];
}

    $stmt = $conn->prepare("SELECT * FROM newevent where idnewevent=?;");
    $stmt->bind_param("s", $evt);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
	
if($row['clubid']!= $club || $row['token']!=$token){
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
		$stmt = $conn->prepare("INSERT INTO `event_proposal` (`event`, `club`, `from`, `to`, `budget`, `profit`, `est-stu-part`, `desc`) VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
		$stmt->bind_param("ssssssss", $_POST['event'],$_POST['club'],$_POST['from'],$_POST['to'],$_POST['budget'],$_POST['profit'],$_POST['stud'],$_POST['desc']);
		if($stmt->execute()){
			    $stmt = $conn->prepare("SELECT LAST_INSERT_ID();");
				$stmt->execute();
                $res = $stmt->get_result();
				$row =  $res->fetch_assoc();
				$id = $row['LAST_INSERT_ID()'];
				
				$stmt = $conn->prepare("SELECT idhod FROM clubs.hod where club = 'cceclub';");
				$stmt->execute();
                $res = $stmt->get_result();
				$row =  $res->fetch_assoc();
				$idhod = $row['idhod'];
				
				$stmt = $conn->prepare("INSERT INTO `notify` (`title`, `desc`, `for`, `event`) VALUES ( ?, 'New Event Proposal', ?, ?);");
				$stmt->bind_param("sss",$_POST["event"],$idhod,$id);
				$stmt->execute();
			    
				$stmt = $conn->prepare("DELETE FROM `newevent` WHERE `idnewevent`= ? ;");
				$stmt->bind_param("s", $evt);
				$stmt->execute();

			echo "<h1 class='center' style='height: 50%; margin-top: 5%;'>Event Proposal Successfully Submitted</h1>";
			include 'foot.php';
			echo "</body></html>";
			die;
		}else{
			echo "<h2 class='center text-red'>Error, Try Again.</h2><br>";
		}
	}
	$org = getClub($club);
	?>
   <div class="row-padding padding-left container margin-left margin-right white" style="height: auto;">
   	<div class="container white section">
    <h4><b>New Event Proposal</b></h4>
	<form action="" onSubmit="return onSubmit();" method="post">
	   <input class="input border" type="hidden" value="<?=$evt?>" name="evt" required>
	    <input class="input border" type="hidden" value="<?=$token?>" name="token" required>
       <input class="input border" type="hidden" value="<?=$club?>" name="club" required>
        <div class="col 112 margin-bottom">
          <label>Event Name</label>
          <input class="input border" type="text" value="" name="event" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Organized by</label>
          <input class="input border" disabled type="text" value="<?=$org['name']?>" required>
        </div>
        <div class="row-padding" style="margin:0 -16px;">
          <div class="col l4 m6 margin-bottom">
            <label>From</label>
            <input id="from" class="input border" type="date"  name="from" required>
          </div>
          <div class="col l4 m6 margin-bottom">
            <label>To</label>
            <input id="to" class="input border" type="date"  name="to" required>
          </div>
        </div>
		<div class="col 112 margin-bottom">
          <label>Est. Budget</label>
          <input class="input border" type="number" value="" min="0" name="budget" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Est. Profit (Generated Budget)</label>
          <input class="input border" type="number" value="" min="0" name="profit" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Est. Students Participation</label>
          <input class="input border" type="number" value="" min="0" name="stud" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Event Description</label>
          <textarea class="input border" rows="10" name="desc" required></textarea>
        </div>
          <button type="submit" class="button black margin-bottom"><i class="fa fa-paper-plane margin-right"></i>Submit</button>
    </form>
    </div>
   </div>
 <br>
<?php include 'foot.php';?>
</body>
</html>