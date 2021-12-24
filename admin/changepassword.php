
<?php 
$page = "Change Password";
include 'head.php';
?>

<script>
var element = document.getElementById("nav_pass");
element.classList.add("bold");
element.classList.add("light-grey");

function onSubmit(){
	if(document.getElementById("npass").value == document.getElementById("cpass").value){
		return true;
	}else{
		alert('password confirmation failed! Retry..');
		return false;
	}
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
    <p>Password Successfully Changed.</p>
</div>
</div>
<?php
  }else{
?>
<div class="container">
<div class="panel red round-large">
    <h3>Error!</h3>
    <p>Incorrect Old Password. Try Again...</p>
</div>
</div>
<?php
  }
}
?>

  
  <!-- First Block-->
  <div class="row-padding container center white">
	<div class="container white">
        <h4><b>Change Admin Password</b></h4>
    </div>
	<div class="third container">&nbsp;</div>
	<div class="third container">
	<form action="password_action.php" onSubmit="return onSubmit();" method="post">
	    <input type="hidden" name="id" value="<?=$id?>" required>
		<input type="hidden" name="token" value="<?=$token?>" required>
      <div class="section">
        <label>Old Password</label>
        <input id="opass" class="input border text-black" type="password" name="opass" required>
      </div>
      <div class="section">
        <label>New Password</label>
        <input id="npass" class="input border text-black" type="password" name="npass" required>
      </div>
      <div class="section">
        <label>Confirm Password</label>
        <input id="cpass" class="input border text-black" type="password" name="cpass" required>
      </div>
      <button type="submit" class="button black margin-bottom"><i class="fa fa-floppy-o margin-right"></i>Save Changes</button>
    </form>
    </div>
	<div class="third container">&nbsp;</div>
  </div>
  
  <br>

<?php include 'foot.php';?>

</body>
</html>