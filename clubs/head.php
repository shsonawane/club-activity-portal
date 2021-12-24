<?php
session_start();
if($_SESSION['clubid'] != $_GET['clubid'] || $_SESSION['token'] != $_GET['token'] ){
    http_response_code(404);
    die;
}
$clubid = $_SESSION['clubid'];
$token = $_SESSION['token'];
$url = '?clubid='.$clubid.'&token='.$token;
include '../sql.php';
  $club = getClub($clubid);
  if($club['active'] == '0'){
	    include 'signup_done.php';
		session_destroy();
		die;
	}
if(empty($_SESSION['clubname']) || empty($_SESSION['dept'])){
  $_SESSION['clubname'] = $club['name'];
  $_SESSION['dept'] = $club['dept'];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Dashboard - <?=$_SESSION['clubname']?></title>
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
</head><body class="light-grey content" style="max-width:1600px">
<!-- Sidebar/menu -->
<nav class="sidebar collapse white animate-left" style="z-index:3;width:300px;" id="mySidebar">
	<div style="background-color: #f9cb3e">
		<div class="padding">
				<img src="../resource/logo_black.svg" width="30" height="30" class="d-inline-block align-top" alt="">
				<img src="../resource/name.svg" width="150" height="30" class="d-inline-block align-top" alt="">
		</div>
	</div>
	<div class="primary">
		<div class="padding">
			<h4><b><?=$_SESSION['clubname']?></b></h4>
			<h6><?=$_SESSION['dept']?></h6>
		</div>
		<div class="display-topright">
			<a onclick="sidebar_close()" class="hide-large right padding xlarge hover-text-black" title="close menu">
				<i class="fa fa-remove"></i>
			</a>
		</div>
	</div>
  <div class="bar-block">
      <a id="nav_dash" href="dashboard.php<?=$url?>" class="bar-item button padding"><i class="fa fa-dashboard margin-right"></i>Dashboard</a> 
    <a id="nav_pro" href="profile.php<?=$url?>" class="bar-item button padding"><i class="fa fa-cube margin-right"></i>Profile</a> 
    <a id="nav_eve" href="event.php<?=$url?>" class="bar-item button padding"><i class="fa fa-rocket margin-right"></i>Events</a> 
    <a id="nav_rep" href="report.php<?=$url?>" class="bar-item button padding"><i class="fa fa-file-text margin-right"></i>Event Report</a> 
	<a id="nav_cal" href="calander.php<?=$url?>" class="bar-item button padding"><i class="fa fa-calendar margin-right"></i>Event Calendar</a> 
	<a id="nav_fin" href="finance.php<?=$url?>" class="bar-item button padding">&nbsp;<i class="fa fa-inr margin-right"></i> Finance</a> 
	<a id="nav_up" href="updateprofile.php<?=$url?>" class="bar-item button padding"><i class="fa fa-pencil-square-o margin-right"></i>Update Profile</a>
	<a id="nav_pass" href="changepassword.php<?=$url?>" class="bar-item button padding"><i class="fa fa-key margin-right"></i>Change Password</a>  
    <a id="nav_cont" href="contact.php<?=$url?>" class="bar-item button padding"><i class="fa fa-phone margin-right"></i>Contact Info</a>
	<a id="nav_log" href="logout.php" class="bar-item button padding"><i class="fa fa-sign-out margin-right"></i>Logout</a>
  </div>
  <div class="padding">
    <hr class="border-primary">
  </div>
</nav>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="overlay hide-large animate-opacity" onclick="sidebar_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

  <!-- !PAGE CONTENT! -->
<div class="main" style="margin-left:300px">
<script>
var ncount = 0;
function viewNotify(id, report) {
 var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		window.location = "myreport.php<?=$url."&idreport="?>"+report;
    }
  };
  xhttp.open("GET", "delnotify.php<?=$url?>&idnotify="+id, true);
  xhttp.send();
}

function delNotify(id, div) {
 var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		div.parentElement.style.display='none' ;
		// window.location = "";
		ncount--;
		if(ncount == 0)
			document.getElementById("notify").innerHTML = "<i class='fa fa-bell margin-right'></i>";
		else
			document.getElementById("notify").innerHTML = "<i class='fa fa-bell margin-right'></i>" + "<span class='badge small primary'>"+ncount+"</span>";
    }
  };
  xhttp.open("GET", "delnotify.php<?=$url?>&idnotify="+id, true);
  xhttp.send();
}
</script>


  <!-- Header -->
<header id="portfolio">
    <h4 class="right margin hide-large hover-opacity"><b><?=$_SESSION['clubname']?></b></h4>
    <span class="button hide-large xxlarge hover-text-grey" onclick="sidebar_open()"><i class="fa fa-bars"></i></span>
    <div class="container">
    <h1><b id="title"><?php echo $page; ?></b></h1>
	<div  class="dropdown-hover whide-small">
  <?php
      $stmt = $conn->prepare("SELECT * FROM notify where notify.for = '".$clubid."' order by create_time desc;");
      $stmt->execute();
      $res = $stmt->get_result();
	  ?>
	<button id="notify" class="button white hover-black"><i class="fa fa-bell margin-right"></i><?php
		$rowcount = mysqli_num_rows($res);
		if($rowcount != 0){
		echo "<span class='badge small primary'>".$rowcount."</span>";
		}
		?></button>   
<script> ncount = <?=$rowcount?>; </script>		
    <div class="dropdown-content card-4" style="width:500px">
<?php
       while($row =  $res->fetch_assoc()) {
  ?>
         <div onclick="<?php if($row['report'] != null) echo "viewNotify(".$row['idnotify'].",".$row['report'].")"; ?>" title="View Report" class="hover-primary" style="width:100%; cursor: pointer;   border-bottom: 1px solid grey;">
		   <button onclick="event.stopPropagation(); delNotify(<?=$row['idnotify']?>, this); window.event.cancelBubble = 'true'" title="Remove" class="button right transparent hover-primary xxlarge">×</button>
       <div class="padding" style="text-align: left;">
        <h6><?=$row['desc']?></h6>
        <span class="small"><?=$row['title']?></span>
      </div>
	     </div>
<?php
      }
?>
	</div>
  </div>
    &nbsp
  	<div  class="dropdown-hover whide-small" title="Pending Reports">
  <?php
      $stmt = $conn->prepare("SELECT pending,event,name FROM pend inner join events on pending = idevent inner join users on idusers = club where idusers = '".$clubid."' order by events.to desc;");
      $stmt->execute();
      $res = $stmt->get_result();
	  ?>
	<button class="button white hover-black"><i class="fa fa-bullhorn margin-right"></i><span id="notify2" ><?php
		$rowcount = mysqli_num_rows($res);
		if($rowcount != 0){
		echo "<span class='badge small primary'>".$rowcount."</span>";
		}
		?></span></button>   
<script> pcount = <?=$rowcount?>; </script>		
    <div class="dropdown-content card-4" style="width:500px">
<?php
       while($row =  $res->fetch_assoc()) {
  ?>
         <div title="View Report" style="width:100%; cursor: pointer;   border-bottom: 1px solid grey;">
        <div class="padding" style="text-align: left;">
        <h6><b><?=$row['event']?></b> Report Is Not Submited</h6>
        <span>Please submit ASAP.</span>
      </div>
	     </div>
<?php
      }
?>
	</div>
  </div>
 </div>
</header>
<br>