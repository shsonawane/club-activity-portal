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

$stmt = $conn->prepare("UPDATE `users` SET `active`='1' WHERE `idusers`= ?;");
$stmt->bind_param("s", $_GET['idclub']);
 if($stmt->execute()){
	$club= getClub($_GET['idclub']);
	$link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
	mail($club['email'],"Club Account Verified","Your Club Account \"".$_GET['idclub']."\" is Activated.<br><a href='".$link."' target='_blank'>Click Here</a> To Log In");
	header('Location: clubs.php?id='.$_GET['id'].'&token='.$_GET['token']);
 }
?>