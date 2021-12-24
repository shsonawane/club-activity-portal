<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST") {
	
if($_SESSION['hodid'] != $_POST['hodid'] || $_SESSION['token'] != $_POST['token'] ){
    http_response_code(404);
    die;
}

  include '../sql.php';
  $id = $_POST["hodid"];
  $password = $_POST["opass"];
  
  $clubid = $_SESSION['clubid'];
  
  if(getHODLogin($id,$password,$clubid)){
	  $stmt = $conn->prepare("UPDATE `hod` SET `password`= ? WHERE `idhod`= ?;");
	  $stmt->bind_param("ss", $_POST['npass'], $id);
	  if($stmt->execute()){
			header('Location: changepassword.php?hodid='.$_POST['hodid'].'&token='.$_POST['token'].'&result=1');
	  }
  }else{
	  		header('Location: changepassword.php?hodid='.$_POST['hodid'].'&token='.$_POST['token'].'&result=-1');
  }
  $conn->close();
}
?>