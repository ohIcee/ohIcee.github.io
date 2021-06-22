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

$sql = "SELECT origin_location, destination_location FROM favourites WHERE User_ID = :userid AND origin_location = :originlocation AND destination_location = :destinationlocation";
$stmt = $db->prepare($sql);

$stmt->bindValue(':userid', $UserID);
$stmt->bindValue(':originlocation', $OriginLocation);
$stmt->bindValue(':destinationlocation',  $DestinationLocation);

$result = $stmt->execute();

if ($result) {
  //echo "SUCCESS_GET";
} else {
  echo "ERROR_GET";
  return;
}

if ($stmt->fetch()) {
  // RECORD EXISTS
  echo "exists";
} else {
  // RECORD DOESNT EXIST
  echo "notexists";
}

?>
