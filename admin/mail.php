<?php
session_start();
if($_SESSION['id'] != $_GET['id'] || $_SESSION['token'] != $_GET['token'] ){
    http_response_code(404);
    die;
}
$id = $_SESSION['id'];
$token = $_SESSION['token'];
$url = '?id='.$id.'&token='.$token;


$msg ="<h1>New Club Application Form Link</h1>".$_GET['link']."<br><hr>Note: above link can only be used for one submission.";

if(mail($_GET['email'],"New Club Application Form",$msg)){
	echo "<h1>Mail Successfully Sent.</h1>";
}else{
	echo "<h1>Error! Try Again...</h1>";
}

?>