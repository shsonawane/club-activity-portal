<!DOCTYPE html>
<html>

<?php 
$page = "<a id='back' class='text-grey' href='' style='text-decoration: none;'>Event Report</a> / New Report";
include 'head.php';?>

<script>
document.getElementById("back").href = "report.php<?=$url?>";
var element = document.getElementById("nav_rep");
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
    <p>Report Successfully Submited.</p>
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
    <h4><b>New Event Report</b></h4>
	<span class="text-teal margin-bottom">All details are mandatory</span>
	<form action="newreport_action.php" method="post" enctype="multipart/form-data">
	<br>
       <input class="input border" type="hidden" value="<?=$clubid?>" name="clubid" required>
       <input class="input border" type="hidden" value="<?=$token?>" name="token" required>
        <div class="col l12 margin-bottom">
            <label>Title</label>
            <input class="input border" type="text" value="" name="title" required placeholder="Example: Some Event Report">
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
	  	<option value="<?=$row["idevent"]?>" ><?=$row["event"]?></option>
<?php
      }
?>
</select>
        </div>
		<div class="col l12 margin-bottom">
            <label>Peer Institute Participation</label>
            <input class="check" onchange="func(this);" type="checkbox" value="1" name="peer">
        </div>
		<div id="peer" class="col l12 margin-bottom" style="display: none;">
            <label>Peer Institute</label>
            <input id="pins" class="input border" type="text" name="inst">
        </div>
        <div class="row-padding" style="margin:0 -16px;">
          <div class="col l4 m6 margin-bottom">
            <label>From</label>
            <input class="input border" type="date"  name="from" required>
          </div>
          <div class="col l4 m6 margin-bottom">
            <label>To</label>
            <input class="input border" type="date"  name="to" required>
          </div>
        </div>
		<div class="col 112 margin-bottom">
          <label>Expenses</label>
          <input class="input border" type="number" value="" name="exp" min="0" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Student Participation</label>
          <input class="input border" type="number" value="" min="0" name="stud" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Associated Faculty</label>
          <input class="input border" type="text" value="" name="faculty" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Event Coordinator(s)</label>
          <input class="input border" type="text" value="" name="coord" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Description (min 600 words)</label>
          <textarea class="input border" name="desc" rows="8" required></textarea>
        </div>
		<div class="col 112 margin-bottom">
          <label>Pictures</label>
		  <div class="border">
			<input class="padding" type="file" accept="image/*"  name="img1" id="img1" required> <br>
			<input class="padding" type="file" accept="image/*"  name="img2" id="img2" required> <br>
			<input class="padding" type="file" accept="image/*"  name="img3" id="img3" required> 
		  </div>
        </div>
		<div class="col 112 margin-bottom">
          <label>Video (max size 100 MB)</label>
		  <div class="border">
			<input class="padding" type="file" accept="video/*"  name="film" id="film" required> <br>
		  </div>
        </div>
          <button type="submit" class="button black margin-bottom"><i class="fa fa-paper-plane margin-right"></i>Submit</button>
    </form>
    </div>
   </div>
  <script>
	function func(x){
	  if (x.checked){
			document.getElementById("peer").style.display = "block";
			document.getElementById("pins").required = true;
		} else {
			document.getElementById("peer").style.display = "none";
			document.getElementById("pins").required = false;
		}
	}
  </script>
  <br>

<?php include 'foot.php';?>

</body>
</html>