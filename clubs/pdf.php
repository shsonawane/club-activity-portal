<?php
session_start();

if($_SESSION['token'] != $_GET['token']){
    http_response_code(404);
    die;
}

include '../sql.php';

    $stmt = $GLOBALS['conn']->prepare("SELECT events.event,users.name,reports.from,reports.to,exp,`stu-part`,reports.desc,faculty,coord,reports.type,reports.collage FROM reports inner join users on reports.clubid = users.idusers inner join events on events.idevent = reports.event where idreport = ?;");
    $stmt->bind_param("s", $_GET['idreport']);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
	
 $datefrom = date_create($row["from"]);
			 $dateto = date_create($row["to"]);
?>
<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
<style>
body{font-family: "Montserrat", sans-serif;}
pre {
	display: block;
	font-family: arial;
    white-space: pre-wrap;   
    white-space: -moz-pre-wrap;
    white-space: -pre-wrap;  
    white-space: -o-pre-wrap;  
    word-wrap: break-word; 
}
table {
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid black;
	padding: 5px;
	font-size: 15px;
}
</style>
</head>
<body style='font-family="sans-serif"' onload="window.print()" target="_blank">
<h1 style="text-align: center;"><strong><?=$row["event"]?></strong></h1>
<h4 style="text-align: center;">Organized By <?=$row["name"]?></h4>
<p>&nbsp;</p>
<center>
<table style="width: 596px;" border="1">
<tbody>
<tr>
<td style="width: 170px;">
<p><strong>From</strong></p>
</td>
<td style="width: 425px;">
<p><?=date_format($datefrom,"M d, Y")?></p>
</td>
</tr>
<tr>
<td style="width: 170px;">
<p><strong>To</strong></p>
</td>
<td style="width: 425px;">
<p><?=date_format($dateto,"M d, Y")?></p>
</td>
</tr>
	<?php 
	if($row["type"] == "peer"){
	?>
	<tr>
<td style="width: 170px;">
<p><strong>Peer Institute</strong></p>
</td>
<td style="width: 425px;">
<p><?=$row["collage"]?></p>
</td>
</tr>
	<?php
	}
	?>
<tr>
<td style="width: 170px;">
<p><strong>Expenses</strong></p>
</td>
<td style="width: 425px;">
<p><?=$row["exp"]?></p>
</td>
</tr>
<tr>
<td style="width: 170px;">
<p><strong>Student Participation</strong></p>
</td>
<td style="width: 425px;">
<p><?=$row["stu-part"]?></p>
</td>
</tr>
<tr>
<td style="width: 170px;">
<p><strong>Faculty</strong></p>
</td>
<td style="width: 425px;">
<p><?=$row["faculty"]?></p>
</td>
</tr>
<tr>
<td style="width: 170px;">
<p><strong>Event Coordinator(s)</strong></p>
</td>
<td style="width: 425px;">
<p><?=$row["coord"]?></p>
</td>
</tr>
</tbody>
</table>
</center>
<p>&nbsp;</p>
<pre style="text-align: justify;">
<?=$row["desc"]?>
</pre>
        <hr>
		<br>
		  <?php
		      $stmt = $conn->prepare("SELECT * FROM media where report = ?;");
    $stmt->bind_param("s", $_GET['idreport']);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
	$link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/ClubActivity/";
		  ?>
		  <center>
		<?php	list($width, $height) = getimagesize($link."".$row["img1"]); 
		$height = 600/($width/$height) ?>
      <img src="<?=$link."".$row["img1"]?>" alt="image1" width="600"  height="<?=$height?>"><br><br>
		<?php	list($width, $height) = getimagesize($link."".$row["img2"]);
		$height = 600/($width/$height) ?>
      <img src="<?=$link."".$row["img2"]?>" alt="image1" width="600"  height="<?=$height?>"><br><br>
	  		<?php	list($width, $height) = getimagesize($link."".$row["img3"]);
		$height = 600/($width/$height) ?>
      <img src="<?=$link."".$row["img3"]?>" alt="image1" width="600"  height="<?=$height?>"><br><br>
	  </center>
	  <hr>
	  
	  <p>Video Link: <a href="<?=$link."".$row["vid"]?>"><?=$link."".$row["vid"]?></a></p>
</body>
</html>