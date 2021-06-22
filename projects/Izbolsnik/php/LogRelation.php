<?php

session_start();
if (!isset($_SESSION["user_id"])) {
  die("Not Logged in!");
  return;
}

require_once('DBConnect.php');

$UserID = $_SESSION['user_id'];
$OriginLocation = $_POST['originLocation'];
$DestinationLocation = $_POST['destinationLocation'];

$sql = "INSERT INTO relationHistory (User_ID, origin_location, destination_location) VALUES (:userid, :originlocation, :destinationlocation)";
$stmt = $db->prepare($sql);

$stmt->bindValue(":userid", $UserID);
$stmt->bindValue(":originlocation", $OriginLocation);
$stmt->bindValue(":destinationlocation", $DestinationLocation);

$result = $stmt->execute();

if ($result) {
  echo "SUCCESS_INSERT";
} else {
  echo "ERR_INSERT";
}

?>
