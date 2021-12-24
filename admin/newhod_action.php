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
	$pwd = bin2hex(openssl_random_pseudo_bytes(3));
	$stmt = $conn->prepare("INSERT INTO `hod` (`idhod`, `name`, `email`, `phone`, `club`, `password`) VALUES (?, ?, ?, ?, ?, ?);");
    $stmt->bind_param("ssssss",$_GET['idhod'],$_GET['name'],$_GET['email'],$_GET['phone'],$_GET['club'],$pwd);
if($stmt->execute()){
			header("Location: accounts.php".$url."&password=".$pwd."&result=1");
}else{
			header("Location: accounts.php".$url."&result=-1");
}
?>