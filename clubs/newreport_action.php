<?php
session_start();

if($_SESSION['clubid'] != $_POST['clubid'] || $_SESSION['token'] != $_POST['token'] ){
    http_response_code(404);
    die;
}
$clubid = $_SESSION['clubid'];
$token = $_SESSION['token'];
$url = '?clubid='.$clubid.'&token='.$token;

include '../sql.php';
include 'upload_file.php';

$type = "";
$clg = "";

if(empty($_POST['peer'])){
	$type = "gen";
	$clg = null;
}else{
	$type = "peer";
	$clg = $_POST['inst'];
}

if(!createReport($clubid, $_POST['title'], $_POST['event'], $_POST['from'], $_POST['to'], $_POST['exp'], $_POST['stud'], $_POST['faculty'], $_POST['coord'], $_POST['desc'], $type, $clg)){
	  $img1 = uploadFile("img1");
	  $img2 = uploadFile("img2");
	  $img3 = uploadFile("img3");
	  $film = uploadFile("film");
	  
	  $stmt = $conn->prepare("SELECT LAST_INSERT_ID();");
      $stmt->execute();
      $res = $stmt->get_result();
      $row =  $res->fetch_assoc(); 
	  $clb = GETClub($clubid);
	  
	  if($img1 && $img2 && $img3 && $film){
			if(insertMedia($row['LAST_INSERT_ID()'], $img1, $img2, $img3, $film)){
				header("Location: newreport.php".$url."&result=-2");
			echo "error db";
			}
	  }else{
		  	header("Location: newreport.php".$url."&result=-2");
			echo "error up";
	  }
	  
	    $stmt = $conn->prepare("DELETE FROM `pend` WHERE `pending`= ?;");
		$stmt->bind_param("s", $_POST['event']);
		$stmt->execute();
	  
	  
	  insertNotify("admin", $_POST['title'], "New Report from  ".$clb['name']."", $row['LAST_INSERT_ID()']);
			header("Location: newreport.php".$url."&result=1");
}else{
			header("Location: newreport.php".$url."&result=-1");
}
?>