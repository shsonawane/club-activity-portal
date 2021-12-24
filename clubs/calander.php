
<?php 
$page = "Event Calendar";
include 'head.php';
?>

<script>
var element = document.getElementById("nav_cal");
element.classList.add("bold");
element.classList.add("light-grey");
</script>
  
  <!-- First Block-->
  <!--div class="row-padding padding container margin-left margin-right white center">
	<iframe src="https://calendar.google.com/calendar/embed?src=6pcnaj486dbpee60g7bc1aumo4%40group.calendar.google.com&ctz=Asia%2FCalcutta" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
  </div-->
  
  <br>
  
  	<div class="row-padding padding container margin-left margin-right white center">
        <h4><b>All Events</b></h4>
  <table class="table striped bordered border">
    <tr>
      <th>Event</th>
	  <th>Organized By</th>
      <th>From</th>
      <th>To</th>
    </tr>
	  <?php
      $stmt = $conn->prepare("SELECT * FROM events order by events.from;");
      $stmt->execute();
      $res = $stmt->get_result();
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