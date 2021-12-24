<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST") {
	
if($_SESSION['clubid'] != $_POST['clubid'] || $_SESSION['token'] != $_POST['token'] ){
    http_response_code(404);
    die;
}

  include '../sql.php';
  
  $id = $_POST["clubid"];
  $password = $_POST["opass"];
  
    $stmt = $conn->prepare("SELECT password FROM users where idusers = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
  
  if($row["password"] == $password){
	  $stmt = $conn->prepare("UPDATE `users` SET `password`= ? WHERE `idusers`= ?;");
	  $stmt->bind_param("ss", $_POST['npass'], $id);
	  if($stmt->execute()){
			header('Location: changepassword.php?clubid='.$_POST['clubid'].'&token='.$_POST['token'].'&result=1');
	  }
  }else{
	  		header('Location: changepassword.php?clubid='.$_POST['clubid'].'&token='.$_POST['token'].'&result=-1');
  }
  $conn->close();
}
?>