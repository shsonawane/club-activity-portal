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
    $stmt = $conn->prepare("INSERT INTO `funds` (`user`, `eventid`, `sponser`, `amt`) VALUES (?, ?, ?, ?);");
    $stmt->bind_param("ssss",$clubid, $_GET['event'],$_GET['source'],$_GET['amt']);
if($stmt->execute()){
	header("Location: finance.php".$url."&result=1");
}else{
    header("Location: finance.php".$url."&result=-1");
}
?>