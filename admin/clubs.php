<!DOCTYPE html>
<html>

<?php 
$page = "Clubs, Dept, CCS";
include 'head.php';?>

<script>
var element = document.getElementById("nav_up");
element.classList.add("bold");
element.classList.add("light-grey");

  function act() {
	var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("div")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";

        }
    }
   }
   
   function accept(url){
   if(confirm("Are you sure you want to accept club application")){
   window.location = 'club_accept.php'+url;
   }
   }
   
   function reject(url){
   if(confirm("Are you sure you want to reject club application")){
   window.location = 'club_reject.php'+url;
   }
   }
</script>
  
  
  <!-- First Block-->
      <div class="row-padding padding-left container margin-left margin-right white " style="height: auto;">
      <br><h3><b>New Club Application</b><h3>
   </div>
    <div class="row-padding padding-left container margin-left margin-right white" style="height: auto;">
<div class="container">
  <br>
  <ul class="ul border center" >
  <?php
      $stmt = $conn->prepare("SELECT * FROM users where active = 0 order by name");
      $stmt->execute();
      $res = $stmt->get_result();
	  
	  $rowcount = mysqli_num_rows($res);
	  if($rowcount == 0){
	  echo "<h6 class='padding'>No new club application.</h6>";
	  }
       while($row =  $res->fetch_assoc()) {
  ?>
	<li id="<?=$row["idusers"]?>" class="container center" style="width: 100%;">
      <div class="bar-item">
        <h5><b><?=$row["name"]?></b></h5>
		<span><?=$row["dept"]?></span><br>
		<br>
		<i class="fa fa-phone"></i> <span><?=$row["phone"]?></span><br>
		<i class="fa fa-envelope"></i> <span><?=$row["email"]?></span><br><br>
		<button onclick="accept('<?=$url."&idclub=".$row["idusers"]?>')" class="button green">Accept</button>
		<button onclick="reject('<?=$url."&idclub=".$row["idusers"]?>')" class="button red">Reject</button>
		<button onclick="window.location = 'new_club.php<?=$url."&idclub=".$row["idusers"]?>';" class="button black">&nbspView&nbsp</button>
      </div></li>
<?php
      }
?>
  </ul>
  <br>
</div>
   </div>
  <br>
  
    <div class="row-padding padding-left container margin-left margin-right white " style="height: auto;">
      <br><h3><b>Search Clubs</b><h3>
   </div>
    <div class="row-padding padding-left container margin-left margin-right white" style="height: auto;">
<div class="container">
  <input class="input border" type="text" id="myInput" onkeyup="act()" placeholder="Enter Club Name">
  <br>
  <ul id="myUL" class="ul border" >
  <?php
      $stmt = $conn->prepare("SELECT * FROM users where active = 1 order by name");
      $stmt->execute();
      $res = $stmt->get_result();
       while($row =  $res->fetch_assoc()) {
  ?>
	<li onclick="window.location = 'myclub.php<?=$url."&idclub=".$row["idusers"]?>';" id="<?=$row["idusers"]?>" class="hover-primary center button" style="width: 100%;">
      <div class="bar-item">
        <h5><b><?=$row["name"]?></b></h5>
		<span><?=$row["dept"]?></span><br>
      </div></li>
<?php
      }
?>
  </ul>
  <br>
</div>
   </div>
  <br>

<?php include 'foot.php';?>

</body>
</html>