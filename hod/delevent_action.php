<?php
session_start();
if($_SESSION['hodid'] != $_GET['hodid'] || $_SESSION['token'] != $_GET['token'] ){
    http_response_code(404);
    die;
}
$hodid = $_SESSION['hodid'];
$token = $_SESSION['token'];
$url = '?hodid='.$clubid.'&token='.$token;
include '../sql.php';

$stmt = $conn->prepare("DELETE FROM `events` WHERE `idevent`= ?;");
$stmt->bind_param("s", $_GET['idevent']);
$stmt->execute();

header('Location: event.php?hodid='.$_GET['hodid'].'&token='.$_GET['token']);
?>