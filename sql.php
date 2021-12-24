<?php
$servername = "localhost";
$username = "root";
$password = "<PASSWORD>";
$dbname = "clubs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function createAccount($id, $cname, $dept, $pres, $vicepres, $about, $phone, $email, $web, $pass, $type) {
    $stmt = $GLOBALS['conn']->prepare("INSERT INTO `users` (`idusers`, `name`, `dept`, `president`, `vice-president`, `about`, `phone`, `email`, `web`, `password`, `type`, `active`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0');");
    $stmt->bind_param("sssssssssss", $id, $cname, $dept, $pres, $vicepres, $about, $phone, $email, $web, $pass, $type);
    $stmt->execute();
    $ret = mysqli_errno($GLOBALS['conn']);
	echo mysqli_error($GLOBALS['conn']);
    $stmt->close();
    return $ret;
}

function updateAccount($id, $cname, $dept, $pres, $vicepres, $about, $phone, $email, $web) {
    $stmt = $GLOBALS['conn']->prepare("UPDATE `users` SET `name`=?, `dept`=?, `president`=?, `vice-president`=?, `about`=?, `phone`=?, `email`=?, `web`=? WHERE `idusers`=?;");
    $stmt->bind_param("sssssssss", $cname, $dept, $pres, $vicepres, $about, $phone, $email, $web, $id);
    $flg = $stmt->execute();
    $stmt->close();
		echo mysqli_error($GLOBALS['conn']);
    return $flg;
}

function getHODLogin($id, $password, $type){
    $stmt = $GLOBALS['conn']->prepare("SELECT password FROM hod where idhod = ? and club = ?;");
    $stmt->bind_param("ss", $id, $type);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    return $row["password"] == $password;
}

function getLogin($id, $password, $type){
    $stmt = $GLOBALS['conn']->prepare("SELECT password FROM users where idusers = ? and type= ?");
    $stmt->bind_param("ss", $id, $type);
    $stmt->execute();
    $res = $stmt->get_result();
  //  while($row =  $res->fetch_assoc()) {
   //     echo $row["password"]. "<br>";
 //   }
    $row = $res->fetch_assoc();
    return $row["password"] == $password;
}

function getAdminLogin($id, $password){
    $stmt = $GLOBALS['conn']->prepare("SELECT password FROM admin where uname= ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $res = $stmt->get_result();
  //  while($row =  $res->fetch_assoc()) {
   //     echo $row["password"]. "<br>";
 //   }
    $row = $res->fetch_assoc();
    return $row["password"] == $password;
}

function getClub($id){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM users where idusers = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $res = $stmt->get_result();
  //  while($row =  $res->fetch_assoc()) {
   //     echo $row["password"]. "<br>";
 //   }
    $row = $res->fetch_assoc();
    return $row;
}

function getHOD($id){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM hod where idhod = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    return $row;
}

function getReport($id){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM reports where idreport = ?;");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    return $row;
}


function createReport($id, $title, $event, $from, $to, $funds, $word, $faculty, $coord, $desc, $type, $collage) {
    $stmt = $GLOBALS['conn']->prepare("INSERT INTO `reports` (`clubid`, `title`, `event`, `from`, `to`, `exp`, `stu-part`, `faculty`, `coord`, `desc`, `dateofsub`, `status` , `type`, `collage`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(),0,?,?);
    ");
    $stmt->bind_param("ssssssssssss", $id, $title, $event, $from, $to, $funds, $word, $faculty, $coord, $desc, $type, $collage);
    $stmt->execute();
    $ret = mysqli_errno($GLOBALS['conn']);
	echo mysqli_error($GLOBALS['conn']);
    $stmt->close();
    return $ret;
}

function updateReport($id, $title, $event, $from, $to, $exp, $stu, $faculty, $coord, $desc, $collage) {
    $stmt = $GLOBALS['conn']->prepare("UPDATE `reports` SET `title`= ?, `event`= ?, `from`= ?, `to`= ?, `exp`= ?, `stu-part`= ?, `faculty`= ?, `coord`= ?, `desc`= ?, `collage` = ? WHERE `idreport`= ? and `status`=0;" );
    $stmt->bind_param("sssssssssss", $title, $event, $from, $to, $exp, $stu, $faculty, $coord, $desc, $collage, $id);
    $stmt->execute();
    $ret = mysqli_errno($GLOBALS['conn']);
    $stmt->close();
    return $ret;
}

function insertNotify($id, $title, $desc, $report){
    $stmt = $GLOBALS['conn']->prepare("INSERT INTO `notify` (`title`, `desc`, `for`, `report`) VALUES (?,?,?,?);");
    $stmt->bind_param("ssss", $title, $desc, $id, $report);
    $stmt->execute();
	echo  mysqli_error($GLOBALS['conn']);
    $stmt->close();
}

function insertMedia($report, $img1, $img2, $img3, $flim){
    $stmt = $GLOBALS['conn']->prepare("INSERT INTO `media` (`report`, `img1`, `img2`, `img3`, `vid`) VALUES (?, ?, ?, ?, ?);");
    $stmt->bind_param("sssss", $report, $img1, $img2, $img3, $flim);
	$stmt->execute();   
	$ret = mysqli_errno($GLOBALS['conn']);
	echo mysqli_error($GLOBALS['conn']);
    $stmt->close();
    return $ret;
}

function getEvent($id){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM events where idevent = ?;");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    return $row;
}

//echo "".createAccount("sasff343", "sfasfasf", "sfafs", "9999999999", "fdfsdfds", "dfsdfs"); 
//echo "".updateAccount("cceclub4343", "dfdfdf", "dfdfd", "dfdfdf", "fdfdfd", "fdfdfd", "fdfdf", "fdfdfdf", "fdfdfd", "dfdfdf");
//$conn->close();
//SELECT LAST_INSERT_ID();
?>
