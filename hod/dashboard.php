
<?php 
$page = "Dashboard";
include 'head.php';
if(empty($club)){
    $club = getClub($clubid);
}
?>

<script>
var element = document.getElementById("nav_dash");
element.classList.add("bold");
element.classList.add("light-grey");
</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  
  <!-- First Block-->
    <div class="container row-padding padding-left container margin-left margin-right white" style="height: auto;">
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
  
  <br>

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
<?php include 'foot.php';?>

</body>
</html>