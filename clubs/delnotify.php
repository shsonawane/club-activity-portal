<?php
session_start();
if($_SESSION['clubid'] != $_GET['clubid'] || $_SESSION['token'] != $_GET['token'] ){
    http_response_code(404);
    die;
}

include '../sql.php';
$stmt = $conn->prepare("DELETE FROM `notify` WHERE `idnotify`= ?;");
$stmt->bind_param("s", $_GET['idnotify']);
$stmt->execute();
?>