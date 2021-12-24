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

$stmt = $conn->prepare("SELECT * FROM media where report = ?;");
$stmt->bind_param("s", $_GET['idreport']);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

unlink("../".$row["img1"]);
unlink("../".$row["img2"]);
unlink("../".$row["img3"]);
unlink("../".$row["vid"]);

$stmt = $conn->prepare("DELETE FROM `reports` WHERE `idreport`= ?;");
$stmt->bind_param("s", $_GET['idreport']);
$stmt->execute();
?>