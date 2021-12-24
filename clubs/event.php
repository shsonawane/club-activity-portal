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
	 document.getElementById("inlink").value = this.responseText;
	 document.getElementById("divlink").hidden= false;
    }
  };
  xhttp.open("GET", "event_action.php<?=$url?>", true);
  xhttp.send();
}

</script>

     <!-- First Block-->
	<div class="row-padding padding-left container margin-left margin-right white" style="height: auto;">
   	<div class="container white section">
    <h4><b>New Event Proposal</b></h4>
          <button onclick="getLink();" class="button black margin-bottom"><i class="fa fa-paper-plane margin-right"></i>Click Here</button>
    </div>
	 <div id="divlink" class="container white section" hidden> 
          <a id="link" class="text-indigo margin-bottom" href="" target="_blank"></a><br><br>
		  <form action="mail.php" target="_blank">
		    <input class="input border" type="hidden" value="<?=$clubid?>" name="clubid" required>
			<input class="input border" type="hidden" value="<?=$token?>" name="token" required>
			 <input id="inlink" class="input border" type="hidden" value="" name="link" required>
			<input class="input border" type="email" placeholder="Enter Email Address" name="email" required><br>
			<button type="submit" class="button black margin-bottom"><i class="fa fa-share margin-right"></i>Share Link</button>
		  </form>
    </div>
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