<?php
function uploadFile($file){
if ((($_FILES[$file]["type"] == "video/mp4")
|| ($_FILES[$file]["type"] == "video/wmv")
|| ($_FILES[$file]["type"] == "image/png")
|| ($_FILES[$file]["type"] == "image/pjpeg")
|| ($_FILES[$file]["type"] == "image/gif")
|| ($_FILES[$file]["type"] == "image/jpeg"))

&& ($_FILES[$file]["size"] < 150000000))

  {

  if ($_FILES[$file]["error"] > 0)
    {
		 return 0;
    }
  else
    {
		$loca = "media_upload/".time()."_". $GLOBALS['clubid']."_".$file.".".pathinfo($_FILES[$file]["name"], PATHINFO_EXTENSION);
		move_uploaded_file($_FILES[$file]["tmp_name"], $loca);
		return "clubs/".$loca;
    }
  }
else
  {
	return 0;
  }
}
?>