
<?php 
$page = "<a id='back' class='text-grey' href='' style='text-decoration: none;'>Clubs</a> / ";
include 'head.php';

$club= getClub($_GET['idclub']);
?>

<script>
document.getElementById("title").innerHTML += "<?=$club["name"]?> Application";
document.getElementById("back").href = "clubs.php<?=$url?>";
var element = document.getElementById("nav_up");
element.classList.add("bold");
element.classList.add("light-grey");
   
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
    <div class="row-padding padding-left container margin-left margin-right white" style="height: auto;">
   <br>
    <div class="container white section">
        <h4><b>Club Id</b></h4>
		<p><?=$club['idusers']?></p>
    </div>
	<div class="container white section">
        <h4><b>Name</b></h4>
		<p><?=$club['name']?></p>
    </div>
	<div class="container white section">
        <h4><b>Department</b></h4>
		<p><?=$club['dept']?></p>
    </div>
	<div class="container white section">
        <h4><b>President</b></h4>
		<p><?=$club['president']?></p>
    </div>
	<div class="container white section">
        <h4><b>Vice President</b></h4>
		<p><?=$club['vice-president']?></p>
    </div>
	<div class="container white section">
        <h4><b>About Us</b></h4>
		<p><?=$club['about']?></p>
    </div>
	<div class="container white section">
        <h4><b>Contact</b></h4>
		<p><i class="fa fa-phone margin-right"></i><?=$club['phone']?></p>
		<p><i class="fa fa-envelope margin-right"></i><?=$club['email']?></p>
		<p><i class="fa fa-globe margin-right"></i><?=$club['web']?></p>
    </div>
	<div class="container center">
	   		<button onclick="accept('<?=$url."&idclub=".$club["idusers"]?>')" class="button green">Accept</button>
		<button onclick="reject('<?=$url."&idclub=".$club["idusers"]?>')" class="button red">Reject</button>
	</div>
		<hr>
   </div>
  
  <br>

<?php include 'foot.php';?>

</body>
</html>