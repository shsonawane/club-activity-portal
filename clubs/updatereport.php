<!DOCTYPE html>
<html>

<?php 
$page = "<a id='back' class='text-grey' href='' style='text-decoration: none;'>Event Report</a> / Update Report";
include 'head.php';?>

<script>
document.getElementById("back").href = "report.php<?=$url?>";
var element = document.getElementById("nav_rep");
element.classList.add("bold");
element.classList.add("light-grey");
</script>

<?php
$report = getReport($_GET['idreport']);
if(!empty($_GET["result"])){
  $res = $_GET["result"];
  if($res == 1){
?>
<div class="container">
<div class="panel green round-large">
    <h3>Success!</h3>
    <p>Report Successfully Updated.</p>
</div>
</div>
<?php
  }else{
?>
<div class="container">
<div class="panel red round-large">
    <h3>Error!</h3>
    <p>Report was not Updated. Try Again...</p>
</div>
</div>
<?php
  }
}
?>


     <!-- First Block-->
   <div class="row-padding padding-left container margin-left margin-right white" style="height: auto;">
   	<div class="container white section">
    <h4><b>Update Event Report</b> [<?=$report["title"]?>]</h4>
	 <?php
		if($report["status"] != '0')
            echo "<span class='text-red'>Can't update this report. Only pending reports can be updated.</span>";
     ?>
	<form id="form" action="updatereport_action.php" method="post" enctype="multipart/form-data">
	<br>
       <input class="input border" type="hidden" value="<?=$clubid?>" name="clubid" required>
       <input class="input border" type="hidden" value="<?=$token?>" name="token" required>
       <input class="input border" type="hidden" value="<?=$report["idreport"]?>" name="idreport" required>
        <div class="col l12 margin-bottom">
            <label>Title</label>
            <input class="input border" type="text" value="<?=$report["title"]?>" name="title" required>
        </div>
        <div class="col 112 margin-bottom">
          <label>Event</label>
		  		  	<select id="mySelect" class="input border" name="event" required>
		  <option value="">Select Event</option>
  <?php
      $stmt = $conn->prepare("SELECT * FROM events where club = '".$clubid."';");
      $stmt->execute();
      $res = $stmt->get_result();
       while($row =  $res->fetch_assoc()) {
  ?>
	  	<option value="<?=$row["idevent"]?>" <?php if($row["idevent"]==$report["event"]) echo "selected"?> ><?=$row["event"]?></option>
<?php
      }
?>
</select>
        </div>
			<?php 
	if($report["type"] == "peer"){
	?>
		<div id="peer" class="col l12 margin-bottom">
            <label>Peer Institute</label>
            <input id="pins" class="input border" type="text" value="<?=$report["collage"]?>" name="inst">
        </div>
	<?php
	}
	?>
        <div class="row-padding" style="margin:0 -16px;">
          <div class="col l4 m6 margin-bottom">
            <label>From</label>
            <input class="input border" type="date" value="<?=$report["from"]?>"  name="from" required>
          </div>
          <div class="col l4 m6 margin-bottom">
            <label>To</label>
            <input class="input border" type="date" value="<?=$report["to"]?>" name="to" required>
          </div>
        </div>
		<div class="col 112 margin-bottom">
          <label>Expenses</label>
          <input class="input border" type="number" value="<?=$report["exp"]?>" name="exp" min="0" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Student Participation</label>
          <input class="input border" type="text" value="<?=$report["stu-part"]?>" name="stud" min="0" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Associated Faculty</label>
          <input class="input border" type="text" value="<?=$report["faculty"]?>" name="faculty" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Event Coordinator(s)</label>
          <input class="input border" type="text" value="<?=$report["coord"]?>" name="coord" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Description</label>
          <textarea class="input border" name="desc" rows="8"><?=$report["desc"]?></textarea>
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
	<div id="img1">
      <img src="../<?=$row["img1"]?>" alt="image1" style="width:100%" class="hover-opacity"><br>
	  <button class="button hover-white text-teal" type="button" onclick="replace('img1');">Replace</button>
	</div>
	<input id="in_img1"class='input border' type='file' accept='image/*' name='img1' style="display: none">
    </div>
	
    <div class="col l4 m4 container margin-bottom padding">
	<div id="img2">
      <img src="../<?=$row["img2"]?>" alt="image2" style="width:100%" class="hover-opacity"><br>
	  <button class="button hover-white text-teal" type="button" onclick="replace('img2');">Replace</button>
	</div>
	<input id="in_img2"class='input border' type='file' accept='image/*' name='img2' style="display: none">
    </div>
    
	<div class="col l4 m4 container margin-bottom padding">
	<div id="img3">
      <img src="../<?=$row["img3"]?>" alt="image3" style="width:100%" class="hover-opacity"><br>
	  <button class="button hover-white text-teal" type="button" onclick="replace('img3');">Replace</button>
	</div>
	<input id="in_img3"class='input border' type='file' accept='image/*' name='img3' style="display: none">
    </div>
	
  </div>
    </div>
	<div class="col 112 margin-bottom">
          <label>Add New Video</label>
           <input class="input border" accept="video/*" type="file" name="vid">
    </div>
          <button type="submit" class="button black margin-bottom"><i class="fa fa-floppy-o margin-right"></i>Save Changes</button>
    </form>
    </div>
   </div>
   <script>
var status = <?=$report["status"]?>;
if(status != 0){
  for(var i = 0;i < 13; i++)
    document.forms["form"][i].disabled = true;
}

function replace(x){
	document.getElementById(x).style.display = "none";
	document.getElementById("in_"+x).style.display = "block";
}
</script>
  
  <br>

<?php include 'foot.php';?>

</body>
</html>