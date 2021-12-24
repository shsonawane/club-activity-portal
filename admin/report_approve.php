<?php
session_start();
if($_SESSION['id'] != $_GET['id'] || $_SESSION['token'] != $_GET['token'] ){
    http_response_code(404);
    die;
}
include '../sql.php';
$stmt = $conn->prepare("UPDATE `reports` SET `status`='1' WHERE `idreport`= ?;");
$stmt->bind_param("s", $_GET['idreport']);
 if($stmt->execute()){
	 $report = getReport($_GET['idreport']);
	insertNotify($report["clubid"], $report['title'], "Report Approved.", $report['idreport']);
	header('Location: myreport.php?id='.$_GET['id'].'&token='.$_GET['token']."&idreport=".$_GET["idreport"]);
 }
?>