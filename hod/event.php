<!DOCTYPE html>
<html>

<?php 
$page = "Events";
include 'head.php';?>

<script>
var element = document.getElementById("nav_eve");
element.classList.add("bold");
element.classList.add("light-grey");


function onSubmit(){
	frm = new Date(document.getElementById("from").value);
	to = new Date(document.getElementById("to").value);
	//alert(frm+" "+to);
	if(frm <= to){
		if(confirm("Are You Sure You Want To Create This Event.")){
			return true;
		}
	}else{
		alert("Check Your Dates Again!!")
	}
	return false;
}

function getLink() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     document.getElementById("link").innerHTML = this.responseText;
	 document.getElementById("link").href = this.responseText;
    }
  };
  xhttp.open("GET", "event_action.php<?=$url?>", true);
  xhttp.send();
}

</script>

<?php
if(!empty($_GET["result"])){
  $res = $_GET["result"];
  if($res == 1){
?>
<div class="container">
<div class="panel green round-large">
    <h3>Approved Successfully!</h3>
    <p>Event Successfully Created.</p>
</div>
</div>
<?php
  }else if($res == 2){
?>
<div class="container">
<div class="panel green round-large">
    <h3>Disapproved Successfully!</h3>
    <p>Event Proposal was Successfully Disapproved.</p>
</div>
</div>
<?php
  }else{
?>
<div class="container">
<div class="panel red round-large">
    <h3>Error!</h3>
    <p>Event was not Created. Try Again...</p>
</div>
</div>
<?php
  }
}
?>

     <!-- First Block-->
    	<div class="row-padding padding container margin-left margin-right white center">
        <h4><b>Event Proposals</b></h4>
  <table class="table striped bordered border" style="overflow-x:auto;">
	  <?php
      $stmt = $conn->prepare("SELECT * FROM event_proposal where club = '".$clubid."' order by event_proposal.from;");
      $stmt->execute();
      $res = $stmt->get_result();
	  $rowcount = mysqli_num_rows($res);
	  if($rowcount == 0){
	  echo "<h6 class='padding-16 border'>No Event Proposal</h6>";
	  }else{
		  ?>
	<tr>
      <th>Event</th>
	  <th>Organized By</th>
      <th>From</th>
      <th>To</th>
	  <th>View</th>
    </tr>
		  
		  <?php
	  }
       while($row =  $res->fetch_assoc()) {
		   	 $club = getClub($row["club"]);
			 $datefrom = date_create($row["from"]);
			 $dateto = date_create($row["to"]);
  ?>
	 <tr>
	  <td><?=$row["event"]?></td>
      <td><?=$club["name"]?></td>
      <td><?=date_format($datefrom,"M d, Y")?></td>
      <td><?=date_format($dateto,"M d, Y")?></td>
	  <td><a href="event_proposal.php<?=$url."&idevent=".$row['idevent']?>" >Click Here</a></td>
    </tr>
<?php
      }
?>
  </table>
  <br>
</div>
  
  <br>
  
  <br>
  
    	<div class="row-padding padding container margin-left margin-right white center">
        <h4><b>Our Events</b></h4>
  <table class="table striped bordered border" style="overflow-x:auto;">
	  <?php
      $stmt = $conn->prepare("SELECT * FROM events where club = '".$clubid."' order by events.from");
      $stmt->execute();
      $res = $stmt->get_result();
	  	  $rowcount = mysqli_num_rows($res);
	  	  if($rowcount == 0){
	  echo "<h6 class='padding-16 border'>No Event Available</h6>";
	  }else{
		  ?>
    <tr>
      <th>Event</th>
	  <th>Organized By</th>
      <th>From</th>
      <th>To</th>
	  <th>Status</th>
	  <th>View</th>
    </tr>
		  <?php
	  }
	  
       while($row =  $res->fetch_assoc()) {
		   	 $club = getClub($row["club"]);
			 $datefrom = date_create($row["from"]);
			 $dateto = date_create($row["to"]);
  ?>
	 <tr>
	  <td><?=$row["event"]?></td>
      <td><?=$club["name"]?></td>
      <td><?=date_format($datefrom,"M d, Y")?></td>
      <td><?=date_format($dateto,"M d, Y")?></td>
	  <td><?php
	  $today = date("Y-m-d");
	  $datefrom = $row["from"];
	  $dateto = $row["to"];
	  if($today < $datefrom)
		  echo "upcoming";
	  else if($today > $dateto)
		  echo "over";
	  else if($today >= $datefrom && $today <= $dateto)
		  echo "ongoing"
	  ?></td>
	  <td class="center" ><a href="myevent.php<?=$url?>&idevent=<?=$row["idevent"]?>">view</a></td>
    </tr>
<?php
      }
?>
  </table>
  <br>
</div>
<br>
<?php include 'foot.php';?>

</body>
</html>