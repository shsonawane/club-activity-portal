<?php
session_start();
if($_SESSION['hodid'] != $_GET['hodid'] || $_SESSION['token'] != $_GET['token'] ){
    http_response_code(404);
    die;
}
$clubid = $_SESSION['clubid'];
$hodid = $_SESSION['hodid'];
$token = $_SESSION['token'];
$url = '?hodid='.$hodid.'&token='.$token;
include '../sql.php';
    $stmt = $conn->prepare("INSERT INTO `expences` (`user`, `event`, `for`, `amt`) VALUES (?, ?, ?, ?);");
    $stmt->bind_param("ssss",$clubid, $_GET['event'],$_GET['for'],$_GET['amt']);
if($stmt->execute()){
	header("Location: finance.php".$url."&result=1");
}else{
    header("Location: finance.php".$url."&result=-1");
}
?>