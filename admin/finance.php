
<?php 
$page = "Finance";
include 'head.php';
?>

<script>
var element = document.getElementById("nav_fin");
element.classList.add("bold");
element.classList.add("light-grey");

function select(){
	 var x = document.getElementById("mySelect").value;
	window.location = "finance.php<?=$url?>&club="+x;
}
</script>
  
  <!-- First Block-->
<div class="row-padding padding container margin-left margin-right white">
	<br>
	  <h4><b>Select Club</b></h4>
	<select id="mySelect" class="input border" onchange="select()">
		  <option value="">Select Club/CCS</option>
  <?php
   $clubid = $_GET['club'];
      $stmt = $conn->prepare("SELECT * FROM users where active=1;");
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
</div>
<?php

if(empty($clubid)){
?>
	<div class="row-padding padding center container margin-left margin-right white" style="height: 300px;">
		<h6 class='padding'>No Club Selected</h6>
	</div>
	<br>
<?php	
}else{
?>
  <!-- First Block-->
<div class="row-padding padding container margin-left margin-right white">
	<div class="container white section">
        <h4><b>Last Year Expense</b></h4>
		<p class="large"><i class="fa fa-inr margin-right"></i>25000</p>
    </div>
	<div class="container white section">
        <h4><b>Remaining Funds</b></h4>
		<div id="remfunds" class="large"></div>
    </div>
	</div>
	<br>
<div class="row-padding padding container margin-left margin-right white">
	<div class="container white section">
        <h4><b>Funds (Sources)</b></h4>
  <table class="table striped bordered border">
    <tr>
      <th>Event</th>
      <th>Source/Sponsor</th>
      <th>Amount (Rs.)</th>
    </tr>
	  <?php
	  	  $fund = 0;
      $stmt = $conn->prepare("SELECT * FROM funds where user = '".$clubid."';");
      $stmt->execute();
      $res = $stmt->get_result();
       while($row =  $res->fetch_assoc()) {
		   	 $event = getEvent($row["eventid"]);
			 $fund += $row["amt"];
  ?>
	 <tr>
      <td><?=$event["event"]?></td>
      <td><?=$row["sponser"]?></td>
      <td><?=$row["amt"]?></td>
    </tr>
<?php
      }
?>
  </table>
  <br>
</div>
</div>
<br>
<div class="row-padding padding container margin-left margin-right white">
	<div class="container white section">
        <h4><b>Expenses</b></h4>
  <table class="table striped bordered border">
    <tr>
      <th>Event</th>
      <th>Required For.</th>
      <th>Amount (Rs.)</th>
    </tr>
	  <?php
	  	  $exp = 0;
      $stmt = $conn->prepare("SELECT * FROM expences where user = '".$clubid."';");
      $stmt->execute();
      $res = $stmt->get_result();
       while($row =  $res->fetch_assoc()) {
		   		   		 $exp+= $row["amt"];
		   	 $event = getEvent($row["event"]);
  ?>
	 <tr>
      <td><?=$event["event"]?></td>
      <td><?=$row["for"]?></td>
      <td><?=$row["amt"]?></td>
    </tr>
<?php
      }
	  $rem_funds = $fund - $exp;
?>
  </table>
  <br>
</div>
</div>

<script>
document.getElementById("remfunds").innerHTML = "<i class='fa fa-inr margin-right'></i><?=$rem_funds?>";
</script>

<br>
<?php }
 include 'foot.php';?>

</body>
</html>