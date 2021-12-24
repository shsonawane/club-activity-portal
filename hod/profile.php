
<?php 
$page = "Club Profile";
include 'head.php';
if(empty($club)){
    $club = getClub($clubid);
}
?>

<script>
var element = document.getElementById("nav_pro");
element.classList.add("bold");
element.classList.add("light-grey");
</script>
  
  <!-- First Block-->
    <div class="row-padding padding-left container margin-left margin-right white" style="height: auto;">
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
		<p><i class="fa fa-whatsapp margin-right"></i><?=$club['whatsapp']?></p>
		<p><i class="fa fa-envelope margin-right"></i><?=$club['email']?></p>
		<p><i class="fa fa-globe margin-right"></i><?=$club['web']?></p>
    </div>
   </div>
  
  <br>

<?php include 'foot.php';?>

</body>
</html>