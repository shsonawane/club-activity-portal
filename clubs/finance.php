
<?php 
$page = "Finance";
include 'head.php';
?>

<script>
var element = document.getElementById("nav_fin");
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
    <p>Finance Successfully Updated.</p>
</div>
</div>
<?php
  }else{
?>
<div class="container">
<div class="panel red round-large">
    <h3>Error!</h3>
    <p>Try Again...</p>
</div>
</div>
<?php
  }
}
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
    <h4><b>Add Funds</b></h4>
	<form action="funds_action.php">
       <input class="input border" type="hidden" value="<?=$clubid?>" name="clubid" required>
       <input class="input border" type="hidden" value="<?=$token?>" name="token" required>
        <div class="col 112 margin-bottom">
          <label>Event</label>
		  <select  class="input border" name="event" required>
		  <option>Select Event</option>
  <?php
      $stmt = $conn->prepare("SELECT * FROM events where club = '".$clubid."';");
      $stmt->execute();
      $res = $stmt->get_result();
       while($row =  $res->fetch_assoc()) {
  ?>
	  	<option value="<?=$row["idevent"]?>"><?=$row["event"]?></option>
<?php
      }
?>
		  </select>
        </div>
		<div class="col 112 margin-bottom">
          <label>Source/Sponsor</label>
          <input class="input border" type="text" value="" name="source" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Amount</label>
          <input class="input border" type="number" value="" name="amt" required>
        </div>
          <button type="submit" class="button black margin-bottom"><i class="fa fa-plus"></i> Add</button>
    </form>
    </div>
	
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
    <h4><b>Add Expenses</b></h4>
	<form action="exp_action.php" onsubmit="return validate();">
       <input class="input border" type="hidden" value="<?=$clubid?>" name="clubid" required>
       <input class="input border" type="hidden" value="<?=$token?>" name="token" required>
        <div class="col 112 margin-bottom">
          <label>Event</label>
		  <select  class="input border" name="event" required>
		  <option>Select Event</option>
  <?php
      $stmt = $conn->prepare("SELECT * FROM events where club = '".$clubid."';");
      $stmt->execute();
      $res = $stmt->get_result();
       while($row =  $res->fetch_assoc()) {
  ?>
	  	<option value="<?=$row["idevent"]?>"><?=$row["event"]?></option>
<?php
      }
?>
		  </select>
        </div>
		<div class="col 112 margin-bottom">
          <label>Required For</label>
          <input class="input border" type="text" value="" name="for" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Amount</label>
          <input id="expamt" class="input border" type="number" value="" name="amt" required>
        </div>
          <button type="submit" class="button black margin-bottom"><i class="fa fa-plus"></i> Add</button>
    </form>
    </div>
	
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

function validate(){
	var amt = document.getElementById("expamt").value;
	if( amt > <?=$rem_funds?>){
		alert("Insufficent Funds!");
		return false;
	}else{
		return true;
	}
}
</script>

<br>
<?php include 'foot.php';?>

</body>
</html>