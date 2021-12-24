<?php
session_start();
if($_SESSION['clubid'] != $_GET['clubid'] || $_SESSION['token'] != $_GET['token'] ){
    http_response_code(404);
    die;
}
$clubid = $_SESSION['clubid'];
$token = $_SESSION['token'];
$url = '?clubid='.$clubid.'&token='.$token;
include '../sql.php';

$cname = $_GET['cname'];
$dept = $_GET['dept'];
$pres = $_GET['president'];
$vicepres = $_GET['vpresident'];
$about = $_GET['about'];
$phone = $_GET['phone'];
$email = $_GET['email'];
$web = $_GET['web'];

if(updateAccount($clubid, $cname, $dept, $pres, $vicepres, $about, $phone, $email, $web)){
 header("Location: updateprofile.php".$url."&result=1");
}else{
  header("Location: updateprofile.php".$url."&result=-1");
}

?>