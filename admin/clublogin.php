<?php
session_start();

$idclub = $_GET['idclub'];

if($_SESSION['id'] != $_GET['id'] || $_SESSION['token'] != $_GET['token'] ){
    http_response_code(404);
    die;
}
include '../sql.php';

if(session_destroy()){
      session_start();
      $_SESSION['clubid'] = $idclub;
      $token = bin2hex(openssl_random_pseudo_bytes(16));
      $_SESSION['token'] = $token;
      header('Location: ../clubs/dashboard.php?clubid='.$idclub.'&token='.$token);
}else{
	echo "Error!!! Login and try again....";
	die;
  }
  $conn->close();
?>