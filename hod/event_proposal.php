
<?php 
$page = "<a id='back' class='text-grey' href='' style='text-decoration: none;'>Events</a> / ";
include 'head.php';

  $stmt = $conn->prepare("SELECT * FROM event_proposal where club = ? and idevent = ?;");
  $stmt->bind_param("ss", $clubid, $_GET['idevent']);
  $stmt->execute();
  $res = $stmt->get_result();
  $event =  $res->fetch_assoc();
		   
?>

<script>
document.getElementById("title").innerHTML += "<?=$event["event"]?> Proposal";
document.getElementById("back").href = "event.php<?=$url?>";
var element = document.getElementById("nav_rep");
element.classList.add("bold");
element.classList.add("light-grey");

function onApprove(url){
	if(confirm("Approving this proposal will create new event. Are you sure you want to proceed.")){
		window.location = 'event_approve.php' + url ;
	}
}

function onDisapprove(url){
	if(confirm("Are you sure you want to disapprove this report")){
		window.location = 'event_disapprove.php' + url ;
	}
}
</script>

     <div class="row-padding padding-left container margin-left margin-right white large">
   <center>
       <button onclick="onApprove('<?=$url."&idevent=".$event["idevent"]."&club=".$event["club"]?>');" class="bar-item button hover-white text-green" style="text-align: center; vertical-align: middle; margin-top:20px; display: table-cell;"><i class="fa fa-thumbs-up"></i> Approve</button>
	   <button onclick="onDisapprove('<?=$url."&idevent=".$event["idevent"]."&club=".$event["club"]?>');" class="bar-item button hover-white text-red" style="text-align: center; vertical-align: middle; margin-top:20px; display: table-cell;"><i class="fa fa-thumbs-down"></i> Disapprove</button>	  
   </center>
      </div>
  
  <!-- First Block-->
   <div id="report" class="row-padding padding-left container margin-left margin-right white" style="height: auto;">
	<div class="container white section">
        <h4><b>Event</b></h4>
		<p><?=$event["event"]?></p>
    </div>
	<div class="container white section">
        <h4><b>From</b></h4>
		<p><?=$event["from"]?></p>
    </div>
	<div class="container white section">
        <h4><b>To</b></h4>
		<p><?=$event["to"]?></p>
    </div>
	<div class="container white section">
        <h4><b>Est. Budget</b></h4>
		<p><?=$event["budget"]?> Rs.</p>
    </div>
		<div class="container white section">
        <h4><b>Est. Profit</b></h4>
		<p><?=$event["profit"]?> Rs.</p>
    </div>
	<div class="container white section">
        <h4><b>Est. Student Participation</b></h4>
		<p><?=$event["est-stu-part"]?></p>
    </div>
    <div class="container white section">
        <h4><b>Description</b></h4>
		<pre><?=$event["desc"]?></pre>
    </div>
<br><br>	
   </div>
  
  <br>

<?php include 'foot.php';?>

</body>
</html>