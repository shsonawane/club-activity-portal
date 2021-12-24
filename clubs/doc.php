<?php
session_start();

if($_SESSION['token'] != $_GET['token']){
    http_response_code(404);
    die;
}

include '../sql.php';

    $stmt = $GLOBALS['conn']->prepare("SELECT reports.title,events.event,users.name,reports.from,reports.to,exp,`stu-part`,reports.desc,faculty,coord,reports.type,reports.collage FROM reports inner join users on reports.clubid = users.idusers inner join events on events.idevent = reports.event where idreport = ?;");
    $stmt->bind_param("s", $_GET['idreport']);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
 $datefrom = date_create($row["from"]);
			 $dateto = date_create($row["to"]);
			 
			 $filename = $row["title"];

require_once '../vendor/autoload.php';

$phpWord = new \PhpOffice\PhpWord\PhpWord();

// New section
$section = $phpWord->addSection();

// Define styles

$phpWord->addTitleStyle(1, array('size' => 28, 'bold' => true,), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
$section->addTitle($row["event"], 1);

$phpWord->addTitleStyle(2, array('size' => 14, 'bold' => true,), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
$section->addTitle('Organized By '.$row["name"], 2);

$section->addTextBreak(1);

$boldFontStyleName = 'BoldText';
$phpWord->addFontStyle($boldFontStyleName, array('bold' => true,'size' => 12));

$paragraphStyleName = 'pStyle';
$phpWord->addParagraphStyle($paragraphStyleName, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));

// Add text run
$textrun = $section->addTextRun($paragraphStyleName);;
$textrun->addText('From: ', $boldFontStyleName);
$textrun->addText(date_format($datefrom,"M d, Y"), array('size' => 12));
$textrun = $section->addTextRun($paragraphStyleName);;
$textrun->addText('To: ', $boldFontStyleName);
$textrun->addText(date_format($dateto,"M d, Y"), array('size' => 12));
 
	if($row["type"] == "peer"){
		$textrun = $section->addTextRun($paragraphStyleName);;
		$textrun->addText('Collage: ', $boldFontStyleName);
		$textrun->addText($row["collage"], array('size' => 12));
	}

$textrun = $section->addTextRun($paragraphStyleName);;
$textrun->addText('Expenses: ', $boldFontStyleName);
$textrun->addText($row["exp"], array('size' => 12));
$textrun = $section->addTextRun($paragraphStyleName);;
$textrun->addText('Student Participation: ', $boldFontStyleName);
$textrun->addText($row["stu-part"], array('size' => 12));
$textrun = $section->addTextRun($paragraphStyleName);;
$textrun->addText('Faculty: ', $boldFontStyleName);
$textrun->addText($row["faculty"], array('size' => 12));
$textrun = $section->addTextRun($paragraphStyleName);;
$textrun->addText('Event Coordinator(s): ', $boldFontStyleName);
$textrun->addText($row["coord"], array('size' => 12));

$section->addTextBreak(1);

$section->addText(
    $row["desc"],
    array('size' => 11),
    array('widowControl' => false,'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH)
);

$section->addTextBreak(1);

 $stmt = $conn->prepare("SELECT * FROM media where report = ?;");
    $stmt->bind_param("s", $_GET['idreport']);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
	
	$link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/ClubActivity/";
	
	list($width, $height) = getimagesize($link."".$row["img1"]); 
		$height = 600/($width/$height);

	$section->addImage('../'.$row['img1'], array('width' => 600, 'height' => $height, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

	list($width, $height) = getimagesize($link."".$row["img1"]); 
		$height = 600/($width/$height);
		
	$section->addImage('../'.$row['img2'], array('width' => 600, 'height' => $height, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

	list($width, $height) = getimagesize($link."".$row["img1"]); 
		$height = 600/($width/$height);

	$section->addImage('../'.$row['img3'], array('width' => 600, 'height' => $height, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

$section->addTextBreak(1);

$section->addText('Video Link: ',array('size' => 11,'bold' => true));
$section->addLink($link."".$row["vid"], $link."".$row["vid"]);
$section->addTextBreak();


header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment;filename="'.$filename.'.docx"');

$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save('php://output');
?>