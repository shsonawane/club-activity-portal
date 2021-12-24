<!DOCTYPE html>
<html>

<?php 
$page = "Event Report";
include 'head.php';?>

<script>
var element = document.getElementById("nav_rep");
element.classList.add("bold");
element.classList.add("light-grey");

  function approvedfilter() {
	var ul,li,a;
	ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
	for (i = 0; i < li.length; i++) {
         var status = li[i].getElementsByTagName("input")[0].value;
		if (status == '0' || status == '-1') {
            li[i].style.display = "none";
        } else {
            li[i].style.display = "";

        }
    }
   }
   
  function disappfilter() {
	var ul,li,a;
	ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
	for (i = 0; i < li.length; i++) {
         var status = li[i].getElementsByTagName("input")[0].value;
		if (status == '0' || status == '1') {
            li[i].style.display = "none";
        } else {
            li[i].style.display = "";

        }
    }
   }
   
  function pendingfilter() {
	var ul,li,a;
	ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
	for (i = 0; i < li.length; i++) {
         var status = li[i].getElementsByTagName("input")[0].value;
		if (status == '-1' || status == '1') {
            li[i].style.display = "none";
        } else {
            li[i].style.display = "";

        }
    }
   }
   
  function allfilter() {
	var ul,li,a;
	ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
	for (i = 0; i < li.length; i++) {
            li[i].style.display = "";
    }
   }
</script>
  
  <!-- First Block-->
    <div class="row-padding padding-left container margin-left margin-right white " style="height: auto;">
	<div onclick="window.location = 'newreport.php<?=$url?>';" class="l6 right margin container hover-text-grey  text-green hover-white button ">
	  <span class="jumbo"><i class="fa fa-plus"></i></span>
      <br><b>NEW REPORT</b>
    </div>
    <div class="margin container xxlarge button hover-white hover-text-black" style="cursor:auto;">
      <br><h1><b>Your Reports</b><h1>
    </div>
	<form class="margin container">
	 Filter:
		<input class="radio" type="radio" onclick="allfilter();" name="filter" checked>
		<label>All</label>
		<input class="radio" type="radio" onclick="pendingfilter();" name="filter">
		<label>Pending</label>
		<input class="radio" type="radio" onclick="approvedfilter();" name="filter">
		<label>Approved</label>
		<input class="radio" type="radio" onclick="disappfilter();" name="filter">
		<label>Disapproved</label>
	</form>
   </div>
   
    <div class="row-padding padding-left container margin-left margin-right white" style="height: auto;">
<div class="container">
  <input class="input border" type="text" id="myInput" onkeyup="myFunction()" placeholder="Search Report">
  <ul id="myUL" class="ul panel border">
  <?php
      $stmt = $conn->prepare("SELECT idreport,title,reports.status,events.event,dateofsub FROM reports inner join events on reports.event = events.idevent where clubid = ? order by dateofsub desc;");
      $stmt->bind_param("s", $clubid);
      $stmt->execute();
      $res = $stmt->get_result();
       while($row =  $res->fetch_assoc()) {
  ?>
	<li id="id<?=$row["idreport"]?>" class="bar">
		<input type="hidden" value="<?=$row["status"]?>">
      <div class="bar-item">
        <h5><b><?=$row["title"]?></b></h5>
        <span>Event: </span><span class="text-grey"><?=$row["event"]?></span><br>
        <span>Status : </span>
        <?php
		if($row["status"] == '1')
            echo "<span name='app' class='text-green'><b>Approved</b></span><br>";
        else if($row["status"] == '-1')
            echo "<span name='disapp' class='text-red'><b>Disapproved</b></span><br>";
        else if($row["status"] == '0')
            echo "<span name='apend' class='text-orange'>Approval pending</span><br>";
        ?>
		  <span>Submitted on: </span><span class="text-grey"><?=$row["dateofsub"]?></span>
      </div>
      <button onclick="delReport(<?=$row["idreport"]?>)" class="bar-item button hover-white text-red white right large" style="text-align: center; vertical-align: middle; margin-top:20px; display: table-cell;"><i class="fa fa-trash"></i> Delete</button>
      <button onclick="window.location = 'updatereport.php<?=$url."&idreport=".$row["idreport"]?>';" class="bar-item button hover-white text-blue white right large" style="text-align: center; vertical-align: middle; margin-top:20px; display: table-cell;"><i class="fa fa-pencil"></i> Update</button>
     <button onclick="window.location = 'myreport.php<?=$url."&idreport=".$row["idreport"]?>';" class="bar-item button primary right" style="text-align: center; vertical-align: middle; height: 50px; width:100%; display: table-cell;">view</button>
  </li>
<?php
      }
?>
  </ul>
</div>

   </div>
   <script>
function myFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("div")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";

        }
    }
}

function delReport(id){
 if(confirm("Are you sure you want to delete this report?")){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {    
      var elem = document.getElementById("id"+id);
      elem.parentNode.removeChild(elem);
    }else if (this.readyState == 4) {    
      alert("Error! Try Again");
    }
  };
  xhttp.open("GET", "delreport_action.php<?=$url."&idreport="?>"+id, true);
  xhttp.send();
 }
}
</script>
  
  <br>

<?php include 'foot.php';?>

</body>
</html>