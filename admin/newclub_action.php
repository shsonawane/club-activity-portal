<?php
session_start();
if($_SESSION['id'] != $_GET['id'] || $_SESSION['token'] != $_GET['token'] ){
    http_response_code(404);
    die;
}
$id = $_SESSION['id'];
$token = $_SESSION['token'];
$url = '?id='.$id.'&token='.$token;

include '../sql.php';
	
	$uuid = bin2hex(openssl_random_pseudo_bytes(16));
    
	$stmt = $conn->prepare("INSERT INTO `newevent` (`token`) VALUES (?);");
    $stmt->bind_param("s",$uuid);
if($stmt->execute()){
	  $stmt = $conn->prepare("SELECT LAST_INSERT_ID();");
      $stmt->execute();
      $res = $stmt->get_result();
      $row =  $res->fetch_assoc(); 
	  
	$link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
	echo $link."clubs/newclub.php?evt=".$row['LAST_INSERT_ID()']."&token=".$uuid;
}else{
   
}
?>