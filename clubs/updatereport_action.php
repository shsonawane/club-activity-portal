<?php
session_start();
if($_SESSION['clubid'] != $_POST['clubid'] || $_SESSION['token'] != $_POST['token'] ){
    http_response_code(404);
    die;
}
$clubid = $_SESSION['clubid'];
$token = $_SESSION['token'];
$url = '?clubid='.$clubid.'&token='.$token.'&idreport='.$_POST['idreport'];
include '../sql.php';
include 'upload_file.php';

$stmt = $conn->prepare("SELECT * FROM media where report = ?;");
$stmt->bind_param("s", $_POST['idreport']);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

if(file_exists($_FILES['img1']['tmp_name'])){
	unlink("../".$row["img1"]);
	$file = uploadFile("img1");
	$stmt = $conn->prepare("UPDATE `media` SET `img1`= ? WHERE `idmedia`= ?;");
	$stmt->bind_param("ss", $file, $row["idmedia"]);
	$stmt->execute();
}

if(file_exists($_FILES['img2']['tmp_name'])){
	unlink("../".$row["img2"]);
	$file = uploadFile("img2");
	$stmt = $conn->prepare("UPDATE `media` SET `img2`= ? WHERE `idmedia`= ?;");
	$stmt->bind_param("ss", $file, $row["idmedia"]);
	$stmt->execute();
}

if(file_exists($_FILES['img3']['tmp_name'])){
	unlink("../".$row["img3"]);
	$file = uploadFile("img3");
	$stmt = $conn->prepare("UPDATE `media` SET `img3`= ? WHERE `idmedia`= ?;");
	$stmt->bind_param("ss", $file, $row["idmedia"]);
	$stmt->execute();
}

if(file_exists($_FILES['vid']['tmp_name'])){
	unlink("../".$row["vid"]);
	$file = uploadFile("vid");
	$stmt = $conn->prepare("UPDATE `media` SET `vid`= ? WHERE `idmedia`= ?;");
	$stmt->bind_param("ss", $file, $row["idmedia"]);
	$stmt->execute();
}


if(empty($_POST['inst'])){
	$collage = null;
}else{
	$collage = $_POST['inst'];
}

if(!updateReport( $_POST['idreport'], $_POST['title'], $_POST['event'], $_POST['from'], $_POST['to'], $_POST['exp'], $_POST['stud'], $_POST['faculty'], $_POST['coord'], $_POST['desc'], $collage)){
   header("Location: updatereport.php".$url."&result=1");
}else{
   header("Location: updatereport.php".$url."&result=-1");
}
?>