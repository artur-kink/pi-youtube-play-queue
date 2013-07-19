<html>
<head><title>History</title></head>
<body style="background-color: black; color: white;">

<div>

	<div style="margin-top: 20px;">
	History:
<?php

$mysqli = new mysqli("host", "user", "pw", "db");
if(mysqli_connect_errno()){
  die("Could not resolve mysql connection.");
}

$results = $mysqli->query("select * from history where played = 1 order by reqtime desc;");

if($results){
	echo "<table><tr><th></th><th>Video</th><th>Time</th></tr>";
    while($row = $results->fetch_object()){
       echo "<tr><td><a style='color: white;' href='push.php?video=" . $row->video . "'>Replay</a></td><td><a style='color: white;' href='http://youtube.com/watch?v=" . $row->video . "'>" . $row->title . "</a></td><td>" . $row->reqtime . "</td></tr>";
    }
	echo "</table>";
}

$mysqli->close();
?>
	</div>
</div>

</body>
</html>
