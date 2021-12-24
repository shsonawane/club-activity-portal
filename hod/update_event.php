
<?php 
$page = "<a id='back' class='text-grey' href='' style='text-decoration: none;'>Events</a> / ";
include 'head.php';

  $stmt = $conn->prepare("SELECT * FROM events where club = ? and idevent = ?;");
  $stmt->bind_param("ss", $clubid, $_GET['idevent']);
  $stmt->execute();
  $res = $stmt->get_result();
  $event =  $res->fetch_assoc();
		   
?>

<script>
document.getElementById("title").innerHTML += "<?=$event["event"]?>";
document.getElementById("back").href = "event.php<?=$url?>";
var element = document.getElementById("nav_rep");
element.classList.add("bold");
element.classList.add("light-grey");

function onSubmit(){
	frm = new Date(document.getElementById("from").value);
	to = new Date(document.getElementById("to").value);
	//alert(frm+" "+to);
	if(frm <= to){
			return true;
	}else{
		alert("Check Your Dates Again!!")
	}
	return false;
}
</script>
<?php
if(!empty($_GET["result"])){
  $res = $_GET["result"];
  if($res == 1){
?>
<div class="container">
<div class="panel green round-large">
    <h3>Success!</h3>
    <p>Event Successfully Updated</p>
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
 <div class="row-padding padding-left container margin-left margin-right white" style="height: auto;">
   	<div class="container white section">
    <h4><b>New Event Proposal</b></h4>
	<form action="update_event_action.php" onSubmit="return onSubmit();">
	   <input class="input border" type="hidden" value="<?=$event['idevent']?>" name="idevent" required>
	    <input class="input border" type="hidden" value="<?=$token?>" name="token" required>
       <input class="input border" type="hidden" value="<?=$hodid?>" name="hodid" required>
        <div class="col 112 margin-bottom">
          <label>Event Name</label>
          <input class="input border" type="text" value="<?=$event['event']?>" name="event" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Organized by</label>
          <input class="input border" disabled type="text" value="<?=$club['name']?>" required>
        </div>
        <div class="row-padding" style="margin:0 -16px;">
          <div class="col l4 m6 margin-bottom">
            <label>From</label>
            <input id="from" class="input border" type="date"  name="from" value="<?=$event['from']?>" required>
          </div>
          <div class="col l4 m6 margin-bottom">
            <label>To</label>
            <input id="to" class="input border" type="date"  name="to" value="<?=$event['to']?>" required>
          </div>
        </div>
		<div class="col 112 margin-bottom">
          <label>Est. Budget</label>
          <input class="input border" type="number" value="<?=$event['budget']?>" min="0" name="budget" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Est. Profit (Generated Budget)</label>
          <input class="input border" type="number" value="<?=$event['profit']?>" min="0" name="profit" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Est. Students Participation</label>
          <input class="input border" type="number" value="<?=$event['est-stu-part']?>" min="0" name="stud" required>
        </div>
		<div class="col 112 margin-bottom">
          <label>Event Description</label>
          <textarea class="input border" rows="10" name="desc" required><?=$event['desc']?></textarea>
        </div>
          <button type="submit" class="button black margin-bottom"><i class="fa fa-floppy-o margin-right"></i>Save</button>
    </form>
    </div>
   </div>
  
  <br>

<?php include 'foot.php';?>

</body>
</html>