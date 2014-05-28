<html>
<head><title>Request Play</title></head>
<body style="background-color: black; color: white;">

<div>
	<form action="push.php">

	Youtube url: <input style="width: 250px;" type="text" name="video"/> <input type="submit"/>
	</form>

	<div style="margin-top: 20px;">
<?php
	echo $_GET["msg"]
?>
	</div>

	<div style="margin-top: 20px;">
<?php

$mysqli = new mysqli("host", "user", "pw", "db");
if(mysqli_connect_errno()){
  die("Could not resolve mysql connection.");
}

$lastcheck = $mysqli->query("select * from checkhistory order by checktime desc limit 1;");
if($lastcheck){
	echo "Player last checked the queue at: " . $lastcheck->fetch_object()->checktime;
}
?>
<br/><br/>
Current Queue:
<?php
$results = $mysqli->query("select * from history where played = 0 order by id desc;");
if($results){
    $numrows = mysqli_num_rows($results);
    if($numrows == 0){
        echo "Empty";
    }

    while($row = $results->fetch_object()){
	if($row->isyoutube){
            echo "<div style='margin-top: 5px;'><a style='color: white;' href='http://youtube.com/watch?v=" . $row->video . "'>" . $row->title . "</a> - " . $row->reqtime . "</div>";
        }else{
            echo "<div style='margin-top: 5px;'><a style='color: white;' href='" . $row->video . "'>" . $row->title . "</a> - " . $row->reqtime . "</div>";
        }
    }
}
?>
	</div>
	<div style="margin-top: 20px;">
	Recently Downloaded:
<?php

$results = $mysqli->query("select * from history where played = 1 order by id desc limit 5;");

if($results){
    while($row = $results->fetch_object()){
	if($row->isyoutube){
       	    echo "<div style='margin-top: 5px;'><a style='color:white;' href='push.php?video=" . $row->video . "'>Replay</a><a style='margin-left: 5px; color: white;' href='http://youtube.com/watch?v=" . $row->video . "'>" . $row->title . "</a> - " . $row->reqtime . "</div>";
    	}else{
       	    echo "<div style='margin-top: 5px;'><a style='color: white;' href='" . $row->video . "'>" . $row->title . "</a> - " . $row->reqtime . "</div>";
	}
    }
}

$mysqli->close();
?>
	<br/>
	<a style="color: white;" href="list.php">View entire history</a>
	<a style="color: red;" href="stats.php">Some interesting stats</a>
	</div>

</div>

</body>
</html>
