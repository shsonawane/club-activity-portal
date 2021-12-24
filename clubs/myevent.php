
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
</script>
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