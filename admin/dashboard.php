<!DOCTYPE html>
<html>

<?php 
$page = "Dashboard";
include 'head.php';?>

<script>
var element = document.getElementById("nav_pro");
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

function select(){
	 var x = document.getElementById("mySelect").value;
	window.location = "dashboard.php<?=$url?>&club="+x;
}

</script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  
 <!-- First Block-->
    <div class="container row-padding padding-left container margin-left margin-right white" style="height: auto;">
	<br>
	  <h4><b>Select Club</b></h4>
	<select id="mySelect" class="input border" onchange="select()">
		  <option value="">Select Club/CCS</option>
  <?php
   $clubid = $_GET['club'];
      $stmt = $conn->prepare("SELECT * FROM users where users.active=1;");
      $stmt->execute();
      $res = $stmt->get_result();
       while($row =  $res->fetch_assoc()) {
  ?>
	  	<option value="<?=$row["idusers"]?>" <?php if($clubid == $row["idusers"]) echo "selected='selected'"?> ><?=$row["name"]?></option>
<?php
      }
?>
</select>
<hr>
	        <h4><b>Annual Expenses</b></h4>
	<div class="white" style="overflow-x:auto; overflow-y: hidden;">

<div class="center" id="fin" style="width:100%"></div>
<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Year', 'Expenses in Rupees'],
  <?php
	  $count = 0;
	  $year = 0;
      $stmt = $conn->prepare("SELECT * FROM stats where club='".$clubid."' order by year;");
      $stmt->execute();
      $res = $stmt->get_result();
       while($row =  $res->fetch_assoc()) {
		   $count++;
		   echo "['".$row['year']."', ".$row['exp']."],";
		   $year = $row['year'];
      }
for ($x = $count; $x <= 10; $x++) {
    echo "['".++$year."', 0],";
} 
?>
  ]);

  var options = {'title':'Yearly Expenses in Rupees',  'height':400};

  var chart = new google.visualization.ColumnChart(document.getElementById('fin'));
  chart.draw(data, options);
}
</script>
    </div>
   </div>

      <div class="container row-padding padding-left container margin-left margin-right white" style="height: auto;">
	        <h4><b>Student Participation</b></h4>
	<div class="white" style="overflow-x:auto; overflow-y: hidden;">

<div class="center" id="stu" style="width:100%"></div>
<script type="text/javascript">

// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Year', 'Student Participation (%)'],
  <?php
	  $count = 0;
	  $year = 0;
      $stmt = $conn->prepare("SELECT * FROM stats where club='".$clubid."' order by year;");
      $stmt->execute();
      $res = $stmt->get_result();
       while($row =  $res->fetch_assoc()) {
		   $count++;
		   echo "['".$row['year']."', ".$row['stu']."],";
		   $year = $row['year'];
      }
for ($x = $count; $x <= 10; $x++) {
    echo "['".++$year."', 0],";
} 
?>
  ]);

  var options = {'title':'Yearly students participation', 'height':400};

  var chart = new google.visualization.ColumnChart(document.getElementById('stu'));
  chart.draw(data, options);
}
</script>
    </div>
   </div>
  
  <br>
    <div class="row-padding padding-left container margin-left margin-right white" style="height: auto;">
	<div class="container">
	<br>
		        <h4><b>Pending Reports</b></h4>
  <table class="table striped bordered border">
    <tr>
      <th>Event</th>
	  <th>Organized By</th>
	  <th>From</th>
	  <th>To</th>
    </tr>
	  <?php
      $stmt = $conn->prepare("SELECT event,name,events.from,events.to FROM pend inner join events on pending = idevent inner join users on idusers = club order by events.to desc;");
      $stmt->execute();
      $res = $stmt->get_result();
       while($row =  $res->fetch_assoc()) {
  ?>
	<tr>
	  <td><?=$row["event"]?></td>
      <td><?=$row["name"]?></td>
      <td><?=$row["from"]?></td>
	  <td><?=$row["to"]?></td>
    </tr>
<?php
      }
?>
</table>
<br>
</div>
   </div>
  
  <br>

<?php include 'foot.php';?>

</body>
</html>