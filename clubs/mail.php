<?php
session_start();
if($_SESSION['clubid'] != $_GET['clubid'] || $_SESSION['token'] != $_GET['token'] ){
    http_response_code(404);
    die;
}
$clubid = $_SESSION['clubid'];
$token = $_SESSION['token'];
$url = '?clubid='.$clubid.'&token='.$token;


$msg ="<h1>New Event Proposal Link</h1>".$_GET['link']."<br><hr>Note: above link can only be used for one submission.";

if(mail($_GET['email'],"New Event Proposal Form Link",$msg)){
	echo "<h1>Mail Successfully Sent.</h1>";
}else{
	echo "<h1>Error! Try Again...</h1>";
}

?>