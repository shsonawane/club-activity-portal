<?php
session_start();
if($_SESSION['hodid'] != $_GET['hodid'] || $_SESSION['token'] != $_GET['token'] ){
    http_response_code(404);
    die;
}
$hodid = $_SESSION['hodid'];
$token = $_SESSION['token'];
$url = '?hodid='.$hodid.'&token='.$token;
include '../sql.php';

 $stmt = $conn->prepare("UPDATE `events` SET `event`= ?, `from`= ?, `to`= ?, `budget`= ?, `profit`= ?, `est-stu-part`= ?, `desc`= ? WHERE `idevent`= ?;");
 $stmt->bind_param("ssssssss", $_GET['event'],$_GET['from'],$_GET['to'],$_GET['budget'],$_GET['profit'],$_GET['stud'],$_GET['desc'],$_GET['idevent']);
	
if($stmt->execute()){
header("Location: update_event.php".$url."&idevent=".$_GET['idevent']."&result=1");
}else{
header("Location: update_event.php".$url."&idevent=".$_GET['idevent']."&result=-1");
}

//echo mysqli_error($conn);

?>