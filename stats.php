
<html>
<head><title>Stats</title></head>
<body style="background-color: black; color: white;">

<div>

        <div style="margin-top: 20px;">
<?php

$mysqli = new mysqli("host", "user", "pw", "db");
if(mysqli_connect_errno()){
  die("Could not resolve mysql connection.");
}

$results = $mysqli->query("select count(distinct ip) as users from history;");

if($results){
	echo "<div style='margin-top: 10px;'>Distinct users: " . $results->fetch_object()->users . "</div>";
}

$results = $mysqli->query("select count(*) as count from history;");
if($results){
	echo "<div style='margin-top: 10px;'>Videos played to date: " . $results->fetch_object()->count . "</div>";
}

$results = $mysqli->query("select id, video, title, count(*) as count from history where reqtime > ADDDATE(NOW(), INTERVAL -1 WEEK) group by video order by count desc limit 10;");

if($results){
        echo "<div style='margin-top: 10px;'>Top 10 videos this week: </div><table><tr><th>Video</th><th>Times Played</th></tr>";
    while($row = $results->fetch_object()){
       echo "<tr><td>" . $row->title . "</td><td>" . $row->count . "</td></tr>";
    }
        echo "</table>";
}


$results = $mysqli->query("select id, video, title, count(*) as count from history group by video order by count desc limit 10;");

if($results){
        echo "<div style='margin-top: 10px;'>Top 10 all-time videos: </div><table><tr><th>Video</th><th>Times Played</th></tr>";
    while($row = $results->fetch_object()){
       echo "<tr><td>" . $row->title . "</td><td>" . $row->count . "</td></tr>";
    }
        echo "</table>";
}



?>

	</div>
</div>
</body>
</html>
