<?php

$ip = $_SERVER['REMOTE_ADDR'];

$code  = str_replace(";", " ", $_GET["video"]);

if(strlen($code) != 11){
	$codepos = strrpos($code, "v=");
	if($codepos === false){
		header('Location: play.php?msg=Video not found.');
		exit();
	}else{
		$code = substr($code, $codepos+2, 11);
	}
}

if(strlen($code) != 11){
	header('Location: play.php?msg=Video not found.');
	exit();
}else{

$data = json_decode(file_get_contents("https://www.googleapis.com/youtube/v3/videos?key=APIKEY&id=" . $code . "&part=snippet,contentDetails"));

if(count($data->items) == 0){
	header('Location: play.php?msg=Video not found.');
	exit();
}

if($data->items[0]->id != $code){
	header('Location: play.php?msg=Video not found.');
	exit();
}

$minpos = strrpos($data->items[0]->contentDetails->duration , "M");
$durationmins = substr($data->items[0]->contentDetails->duration, 2, $minpos - 2);

//if(strrpos($data->items[0]->contentDetails->duration , "H") != false || intval($durationmins) > 30){
//	header('Location: play.php?msg=Video too long, keep under 30min.');
//	exit();
//}

$mysqli = new mysqli("host", "user", "pw", "db");
if(mysqli_connect_errno()){
  die("Could not resolve mysql connection.");
  exit();
}

$title = escapeshellcmd($data->items[0]->snippet->title);
$title = str_replace("'", "", $title);

if(strlen($title) > 255){
    $title = substr($title, 0, 255);
}

$result = $mysqli->query("insert into history(ip, video, title, duration)" .
       "values('" . $ip . "', '" . $data->items[0]->id . "','" . $title . "', '" . 
	$data->items[0]->contentDetails->duration . "');");

if($mysqli->error != ""){
	header('Location: play.php?msg=Database connection failed.');
	exit();
}

$mysqli->close();

header('Location: play.php?msg=Added');
}
?>
