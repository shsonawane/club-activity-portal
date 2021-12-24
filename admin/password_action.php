<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST") {
	
if($_SESSION['id'] != $_POST['id'] || $_SESSION['token'] != $_POST['token'] ){
    http_response_code(404);
    die;
}
  include '../sql.php';
  $id = $_POST["id"];
  $password = $_POST["opass"];
  if(getAdminLogin($id,$password)){
	  $stmt = $conn->prepare("UPDATE `admin` SET `password`= ? WHERE `uname`= ?;");
	  $stmt->bind_param("ss", $_POST['npass'], $_POST['id']);
	  if($stmt->execute()){
			header('Location: changepassword.php?id='.$_POST['id'] .'&token='.$_POST['token'].'&result=1');
	  }
  }else{
	  		header('Location: changepassword.php?id='.$_POST['id'] .'&token='.$_POST['token'].'&result=-1');
  }
  $conn->close();
}
?>