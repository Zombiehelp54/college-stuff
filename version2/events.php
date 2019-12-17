<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "events";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       $events = json_decode(file_get_contents('php://input'), true);
      // var_dump($events);
       foreach($events as $event){
         foreach($event as $subEvent){
         $type = $subEvent["type"];
         $time = $subEvent["time"];
         $target = json_encode($subEvent["target"]);
         $sql = "insert into event(type, time, target) values ('$type', '$time', '$target')";
         $conn->query($sql);
       }
       }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  header("content-type: application/json");
  $sql = "select * from event";
  $result = $conn->query($sql);
  $events = Array();
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $event = array("type"=>$row["type"], "target"=>json_decode($row["target"]), "time"=>$row["time"]);
        array_push($events, $event);
      }
    }
    echo json_encode($events);
}
