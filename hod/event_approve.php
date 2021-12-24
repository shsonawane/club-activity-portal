<?php
session_start();
if($_SESSION['hodid'] != $_GET['hodid'] || $_SESSION['token'] != $_GET['token'] ){
    http_response_code(404);
    die;
}
include '../sql.php';
  $stmt = $conn->prepare("SELECT * FROM event_proposal where club = ? and idevent = ?;");
  $stmt->bind_param("ss", $_SESSION['clubid'], $_GET['idevent']);
  $stmt->execute();
  $res = $stmt->get_result();
  $event =  $res->fetch_assoc();
  
  
$stmt = $conn->prepare("DELETE FROM `event_proposal` WHERE `idevent`= ?;");
$stmt->bind_param("s", $_GET['idevent']);
$stmt->execute();

$stmt = $conn->prepare("INSERT INTO `events` (`event`, `club`, `from`, `to`, `budget`, `profit`, `est-stu-part`, `desc`) VALUES (?, ?, ?, ?, ?,?,?,?);");
$stmt->bind_param("ssssssss", $event['event'],$event['club'],$event['from'],$event['to'],$event['budget'],$event['profit'],$event['est-stu-part'],$event['desc']);

if($stmt->execute()){
	$stmt = $conn->prepare("INSERT INTO `notify` (`title`, `desc`, `for`) VALUES ( ?, 'Event Proposal Approved. New Club Event Created.', ?);");
	$stmt->bind_param("ss",$event['event'],$event['club']);
	$stmt->execute();
	header('Location: event.php?hodid='.$_GET['hodid'].'&token='.$_GET['token'].'&result=1');
 }
 
?>