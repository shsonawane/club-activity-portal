
<?php 
$page = "Update Profile";
include 'head.php';
if(empty($club)){
    $club = getClub($clubid);
}
?>

<script>
var element = document.getElementById("nav_up");
element.classList.add("bold");
element.classList.add("light-grey");
</script>

<?php
if(!empty($_GET["result"])){
  $res = $_GET["result"];
  if($res == 1){
?>
<div class="container">
<div class="panel green round-large">
    <h3>Success!</h3>
    <p>Profile Successfully Updated.</p>
</div>
</div>
<?php
  }else{
?>
<div class="container">
<div class="panel red round-large">
    <h3>Error!</h3>
    <p>Profilet was not Updated. Try Again...</p>
</div>
</div>
<?php
  }
}
?>
  
  <!-- First Block-->
  <style>
  .input{
	color: teal;
	font-weight: bold;
  }
  .input:disabled {
    background: white;
	font-weight: normal;
	color: black;
	border-style: none;
  }
  </style>
  
<div class="container white">
	<div class="center container white">
        <h4><b>Update Club Profile</b></h4>
    </div>
	<div class="container">
	  <form id="myForm" action="updateprofile_action.php" onsubmit="onSubmit();">
	  <div class="section">
        <label>Club Id</label>
        <input id="cid" class="form_in input border" type="text" name="cid" value="<?=$club["idusers"]?>" disabled required="">
      </div>
      <div class="section">
        <label>Club Name</label> <a href="javascript:edit('cname');" class="text-teal right">edit</a>
        <input id="cname" class="form_in input border" type="text" name="cname" value="<?=$club["name"]?>" disabled required="">
      </div>
      <div class="section">
        <label>Department</label> <a href="javascript:edit('dept');" class="text-teal right">edit</a>
        <input id="dept" class="input border" type="text" name="dept" value="<?=$club["dept"]?>" disabled required="">
      </div>
	  <div class="section">
        <label>President</label> <a href="javascript:edit('pres');" class="text-teal right">edit</a>
        <input id="pres" class="input border" type="text" name="president" value="<?=$club['president']?>" disabled >
      </div>
	  <div class="section">
        <label>Vice President</label> <a href="javascript:edit('vp');" class="text-teal right">edit</a>
        <input id="vp" class="input border" type="text" name="vpresident" value="<?=$club['vice-president']?>" disabled >
      </div>
	  <div class="section">
        <label>About Us</label> <a href="javascript:edit('desc');" class="text-teal right">edit</a>
		<textarea id="desc" type="text" class="input border" name="about" rows="10" disabled ><?=$club['about']?></textarea>
       </div>
       <div class="section">
        <label>Contact no.</label> <a href="javascript:edit('phone');" class="text-teal right">edit</a>
        <input id="phone" class="input border" type="number" name="phone" value="<?=$club['phone']?>" disabled required="">
      </div>
      <div class="section">
        <label>Email Id</label> <a href="javascript:edit('emailid');" class="text-teal right">edit</a>
		<input id="emailid" type="text" class="input border" name="email" disabled required="" value="<?=$club['email']?>">
       </div>
       <div class="section">
        <label>Website</label> <a href="javascript:edit('web');" class="text-teal right">edit</a>
		<input id="web" type="text" class="input border" name="web" disabled value="<?=$club['web']?>">
       </div>
       <input class="input border" type="hidden" value="<?=$clubid?>" name="clubid" required>
       <input class="input border" type="hidden" value="<?=$token?>" name="token" required>
		<button id="submit" type="submit" class="button black margin-bottom" style="visibility: hidden;"><i class="fa fa-floppy-o margin-right"></i>Save Changes</button>
    </form>
    </div>
  </div>
  
  <br>

  
<script>
function edit(id){
document.getElementById(id).disabled = false;
document.getElementById(id).focus();
document.getElementById("submit").style.visibility= "visible";
}

function onSubmit(){
document.forms["myForm"]["0"].disabled = false;
document.forms["myForm"]["1"].disabled = false;
document.forms["myForm"]["2"].disabled = false;
document.forms["myForm"]["3"].disabled = false;
document.forms["myForm"]["4"].disabled = false;
document.forms["myForm"]["5"].disabled = false;
document.forms["myForm"]["6"].disabled = false;
document.forms["myForm"]["7"].disabled = false;
document.forms["myForm"]["8"].disabled = false;
document.forms["myForm"]["9"].disabled = false;
}


// Script to open and close sidebar
function sidebar_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
}
 
function sidebar_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
	
}
</script>

<?php include 'foot.php';?>

</body>
</html>