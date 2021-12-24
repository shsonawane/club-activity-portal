
<?php 
$page = "<a id='back' class='text-grey' href='' style='text-decoration: none;'>Event Report</a> / ";
include 'head.php';

$report = getReport($_GET['idreport']);
$club = getClub($report['clubid']);
?>

<script>
document.getElementById("title").innerHTML += "<?=$report["title"]?>";
document.getElementById("back").href = "report.php<?=$url?>";
var element = document.getElementById("nav_rep");
element.classList.add("bold");
element.classList.add("light-grey");

function onApprove(url){
	if(confirm("Are you sure you want to approve this report")){
		window.location = 'report_approve.php' + url ;
	}
}

function onDisapprove(url){
	if(confirm("Are you sure you want to disapprove this report")){
		window.location = 'report_disapprove.php' + url ;
	}
}
</script>

     <div class="row-padding padding-left container margin-left margin-right white large">
  <?php
  if($report["status"] == '0'){
  ?>
   <center>
       <button onclick="onApprove('<?=$url."&idreport=".$report["idreport"]."&club=".$report["clubid"]?>');" class="bar-item button hover-white text-green" style="text-align: center; vertical-align: middle; margin-top:20px; display: table-cell;"><i class="fa fa-thumbs-up"></i> Approve</button>
	   <button onclick="onDisapprove('<?=$url."&idreport=".$report["idreport"]."&club=".$report["clubid"]?>');" class="bar-item button hover-white text-red" style="text-align: center; vertical-align: middle; margin-top:20px; display: table-cell;"><i class="fa fa-thumbs-down"></i> Disapprove</button>	  
   </center>
  <?php
  } else  if($report["status"] == '1'){
		echo "<br><center><h5 class='text-green'><b>Approved <i class='fa fa-thumbs-up'></i></b><h5></center>";
  }else if($report["status"] == '-1'){
		echo "<br><center><h5 class='text-red'><b>Disapproved <i class='fa fa-thumbs-down'></i></b><h5></center>";
  }
   ?>
      </div>
  
  <!-- First Block-->
   <div id="report" class="row-padding padding-left container margin-left margin-right white" style="height: auto;">
    <div class="container white section">
        <h4><b>Title</b></h4>
		<p><?=$report["title"]?></p>
    </div>
	<div class="container white section">
        <h4><b>Event</b></h4>
		<?php $event = getEvent($report["event"])?>
		<p><?=$event["event"]?></p>
    </div>
	<div class="container white section">
        <h4><b>From</b></h4>
		<p><?=$report["from"]?></p>
    </div>
	<div class="container white section">
        <h4><b>To</b></h4>
		<p><?=$report["to"]?></p>
    </div>
	<?php 
	if($report["type"] == "peer"){
	?>
	<div class="container white section">
        <h4><b>Peer Institute</b></h4>
		<p><?=$report["collage"]?></p>
    </div>
	<?php
	}
	?>
	<div class="container white section">
        <h4><b>Expenses</b></h4>
		<p><?=$report["exp"]?></p>
    </div>
	<div class="container white section">
        <h4><b>Student Participation</b></h4>
		<p><?=$report["stu-part"]?></p>
    </div>
    <div class="container white section">
        <h4><b>Faculty</b></h4>
		<p><?=$report["faculty"]?></p>
    </div>
    <div class="container white section">
        <h4><b>Event Coordinator(s)</b></h4>
		<p><?=$report["coord"]?></p>
    </div>
    <div class="container white section">
        <h4><b>Description</b></h4>
		<pre><?=$report["desc"]?></pre>
    </div>
    <div class="container white section">
        <h4><b>Subbmited On</b></h4>
		<p><?=$report["dateofsub"]?></p>
    </div>
	<div class="container white section">
        <h4><b>Images</b></h4>
		  <div class="row-padding border">
		  
		  <?php
		      $stmt = $conn->prepare("SELECT * FROM media where report = ?;");
    $stmt->bind_param("s", $_GET['idreport']);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
	$link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/ClubActivity/";
		  ?>
    <div class="col l4 m4 container margin-bottom padding">
      <img src="<?=$link."".$row["img1"]?>" alt="image1" style="width:100%" class="hover-opacity">
    </div>
    <div class="col l4 m4 container margin-bottom padding">
      <img src="../<?=$row["img2"]?>" alt="image2" style="width:100%" class="hover-opacity">
    </div>
    <div class="col l4 m4 container margin-bottom padding">
      <img src="../<?=$row["img3"]?>" alt="image3" style="width:100%" class="hover-opacity">
    </div>
  </div>
    </div>
	<div class="container white section">
        <h4><b>Video</b></h4>
		<div class="col l2 m2 hide-small container center">
		<br>
		</div>
		<div class="col l8 m8 container center">
			<video class="border " width="100%" controls>
				<source src="../<?=$row["vid"]?>">
				Your browser does not support HTML5 video.
			</video>
		</div>
		<div class="col l2 m2 hide-small container center">
		<br>
		</div>
    </div>
	<hr>
	<div class="">
	<a class="button blue" id="save" href="../clubs/doc.php<?=$url?>&idreport=<?=$report["idreport"]?>">Save <i class="fa fa-file-word-o large"></i></a>
	<a class="button red" id="save" href="../clubs/pdf.php<?=$url?>&idreport=<?=$report["idreport"]?>">Print <i class="fa fa-print large"></i></a>
	</div>
<br><br>	
   </div>
  
  <br>

<?php include 'foot.php';?>

</body>
</html>