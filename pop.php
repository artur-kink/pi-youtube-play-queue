<?php
$mysqli = new mysqli("host", "user", "pw", "db");
if(mysqli_connect_errno()){
  die("Could not resolve mysql connection.");
}
$results = $mysqli->query("select * from history where played = 0 order by reqtime asc limit 1;");
if($results){
    while($row = $results->fetch_object()){
        echo $row->video . "\n";
        $mysqli->query("update history set played = 1 where id = " . $row->id . ";");
    }
}$mysqli->query("insert into checkhistory values(null)");
$mysqli->close();
?>
