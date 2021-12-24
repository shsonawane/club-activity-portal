<?php
session_start();
if($_SESSION['id'] != $_GET['id'] || $_SESSION['token'] != $_GET['token'] ){
    http_response_code(404);
    die;
}
include '../sql.php';
$stmt = $conn->prepare("DELETE FROM `notify` WHERE `newclub`= ?;");
$stmt->bind_param("s", $_GET['idclub']);
$stmt->execute();

$stmt = $conn->prepare("DELETE FROM `users` WHERE `idusers`=?;");
$stmt->bind_param("s", $_GET['idclub']);
 if($stmt->execute()){
	header('Location: clubs.php?id='.$_GET['id'].'&token='.$_GET['token']);
 }
?>