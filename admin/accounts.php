<!DOCTYPE html>
<html>

<?php 
$page = "Events";
include 'head.php';?>

<script>
var element = document.getElementById("nav_acnt");
element.classList.add("bold");
element.classList.add("light-grey");

function getLink() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     document.getElementById("link").innerHTML = this.responseText;
	 document.getElementById("link").href = this.responseText;
	 document.getElementById("inlink").value = this.responseText;
	 document.getElementById("divlink").hidden= false;
    }
  };
  xhttp.open("GET", "newclub_action.php<?=$url?>", true);
  xhttp.send();
}


function resetClub() {
  document.getElementById("spin1").hidden = false;
    var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4) {
		 document.getElementById("spin1").hidden= true;
		if(this.status == 200){
			document.getElementById("res1").innerHTML = "<p class='text-green medium'>Password Successfully Reset.<br>New Password: <b>" + this.responseText + "</b></p>";
		}else{
			document.getElementById("res1").innerHTML = "<p class='text-red medium'>Error! Password Reset Failed, Try Again...</p>";
		}
    }
  };
  xhttp.open("GET", "reset_club_pwd.php<?=$url?>&idclub="+document.getElementById("club").value , true);
  xhttp.send();
}

function resetHOD() {
  document.getElementById("spin2").hidden = false;
    var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4) {
		 document.getElementById("spin2").hidden= true;
		if(this.status == 200){
			document.getElementById("res2").innerHTML = "<p class='text-green medium'>Password Successfully Reset.<br>New Password: <b>" + this.responseText + "</b></p>";
		}else{
			document.getElementById("res2").innerHTML = "<p class='text-red medium'>Error! Password Reset Failed, Try Again...</p>";
		}
    }
  };
  xhttp.open("GET", "reset_hod_pwd.php<?=$url?>&idhod="+document.getElementById("hod").value , true);
  xhttp.send();
}

</script>
<?php
if(!empty($_GET["result"])){
  $res = $_GET["result"];
  if($res == 1){
?>
<div class="container">
<div class="panel green round-large">
    <h3>Success!</h3>
    <p>New HOD account successfully created with password <b>"<?=$_GET["password"]?>"</b></p>
</div>
</div>
<?php
  }else{
?>
<div class="container">
<div class="panel red round-large">
    <h3>Error!</h3>
    <p>Report was not Submited. Try Again...</p>
</div>
</div>
<?php
  }
}
?>
     <!-- First Block-->
	<div class="row-padding padding-left container margin-left margin-right white" style="height: auto;">
   	<div class="container white section">
    <h4><b>New Club/CCS Application</b></h4>
          <button onclick="getLink();" class="button black margin-bottom"><i class="fa fa-paper-plane margin-right"></i>Click Here</button>
    </div>
	 <div id="divlink" class="container white section" hidden> 
          <a id="link" class="text-indigo margin-bottom" href="" target="_blank"></a><br><br>
		  <form action="mail.php" target="_blank">
		    <input class="input border" type="hidden" value="<?=$id?>" name="id" required>
			<input class="input border" type="hidden" value="<?=$token?>" name="token" required>
			 <input id="inlink" class="input border" type="hidden" value="" name="link" required>
			<input class="input border" type="email" placeholder="Enter Email Address" name="email" required><br>
			<button type="submit" class="button black margin-bottom"><i class="fa fa-share margin-right"></i>Share Link</button>
		  </form>
    </div>
   </div>
  
  <br>
  
    	<div class="row-padding padding container margin-left margin-right white">
		   	<div class="container white section">
				 <h4><b>Create New HOD Account</b></h4>
				 <br>
		 <form action="newhod_action.php">
		    <input class="input border" type="hidden" value="<?=$id?>" name="id" required>
			<input class="input border" type="hidden" value="<?=$token?>" name="token" required>
			<div class="col l12 margin-bottom">
            <label>HOD Login Id</label>
            <input class="input border" type="text" value="" name="idhod" required>
			</div>
			<div class="col l12 margin-bottom">
            <label>Name</label>
            <input class="input border" type="text" value="" name="name" required>
			</div>
			<div class="col l12 margin-bottom">
            <label>Email</label>
            <input class="input border" type="email" value="" name="email" required>
			</div>
			<div class="col l12 margin-bottom">
            <label>Phone</label>
            <input class="input border" type="text" value="" name="email" required>
			</div>
			<div class="col l12 margin-bottom">
            <label>Club/CCS</label>
           	<select id="mySelect" class="input border medium" onchange="select()" name="club" required>
		  <option value="">Select Club/CCS</option>
  <?php
      $stmt = $conn->prepare("SELECT * FROM users where users.active=1;");
      $stmt->execute();
      $res = $stmt->get_result();
       while($row =  $res->fetch_assoc()) {
  ?>
	  	<option value="<?=$row["idusers"]?>"><?=$row["name"]?></option>
<?php
      }
?>
</select>
			</div>
			<button type="submit" class="button black margin-bottom"><i class="fa fa-plus margin-right"></i>Create Account</button>
		  </form>
		</div>
			<br>
		</div>
<br>

	<div class="row-padding padding-left container margin-left margin-right white" style="height: auto;">
   	<div class="container white section">
    <h4><b>Club/CCS Account Password Reset</b></h4>
	<form action="javascript:resetClub();">
	     	<select id="club" class="input border medium" onchange="select()" name="club" required>
		  <option value="">Select Club/CCS ID</option>
  <?php
      $stmt = $conn->prepare("SELECT * FROM users where users.active=1;");
      $stmt->execute();
      $res = $stmt->get_result();
       while($row =  $res->fetch_assoc()) {
  ?>
	  	<option value="<?=$row["idusers"]?>"><?=$row["idusers"]?></option>
<?php
      }
?>
</select>
<br>
          <button class="button black margin-bottom"><i class="fa fa-undo margin-right"></i>Reset</button>
		  </form>
			<span  id="spin1" hidden><i class="fa fa-spinner fa-spin xlarge margin-left"></i></span>
			<div id="res1">
			</div>
		   </div>
   </div>
   <br>
   	<div class="row-padding padding-left container margin-left margin-right white" style="height: auto;">
   	<div class="container white section">
    <h4><b>HOD Account Password Reset</b></h4>
	<form action="javascript:resetHOD();">
	     	<select id="hod" class="input border medium" onchange="select()" name="hod" required>
		  <option value="">Select HOD ID</option>
  <?php
      $stmt = $conn->prepare("SELECT * FROM hod;");
      $stmt->execute();
      $res = $stmt->get_result();
       while($row =  $res->fetch_assoc()) {
  ?>
	  	<option value="<?=$row["idhod"]?>"><?=$row["idhod"]?></option>
<?php
      }
?>
</select>
<br>
          <button class="button black margin-bottom"><i class="fa fa-undo margin-right"></i>Reset</button>
		  </form>
		  			<span  id="spin2" hidden><i class="fa fa-spinner fa-spin xlarge margin-left"></i></span>
			<div id="res2">
			</div>
    </div>
   </div>
   <br>
<?php include 'foot.php';?>

</body>
</html>