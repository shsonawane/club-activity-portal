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
	$stmt = $conn->prepare("UPDATE `hod` SET `password`=? WHERE `idhod`=?;");
    $stmt->bind_param("ss",$pwd,$_GET['idhod']);
if($stmt->execute()){
			echo $pwd;
}else{
			http_response_code(404);
}
?>