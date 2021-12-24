<?php
session_start();
if($_SESSION['clubid'] != $_GET['clubid'] || $_SESSION['token'] != $_GET['token'] ){
    http_response_code(404);
    die;
}
$clubid = $_SESSION['clubid'];
$token = $_SESSION['token'];
$url = '?clubid='.$clubid.'&token='.$token;

include '../sql.php';
	
	$uuid = bin2hex(openssl_random_pseudo_bytes(16));
    
	$stmt = $conn->prepare("INSERT INTO `newevent` (`clubid`, `token`) VALUES (?, ?);");
    $stmt->bind_param("ss", $_GET['clubid'],$uuid);
if($stmt->execute()){
	  $stmt = $conn->prepare("SELECT LAST_INSERT_ID();");
      $stmt->execute();
      $res = $stmt->get_result();
      $row =  $res->fetch_assoc(); 
	  
	$link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/ClubActivity/";
	echo $link."clubs/newevent.php?evt=".$row['LAST_INSERT_ID()']."&club=".$clubid."&token=".$uuid;
}else{
   
}
?>