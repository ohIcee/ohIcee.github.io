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
$EditType = $_POST['editType'];
$Exists = false;

CheckIfExists();

function CheckIfExists() {
  global $UserID, $OriginLocation, $DestinationLocation, $db, $Exists;

  $sql = "SELECT origin_location, destination_location FROM favourites WHERE User_ID = :userid AND origin_location = :originlocation AND destination_location = :destinationlocation";
  $stmt = $db->prepare($sql);

  $stmt->bindValue(':userid', $UserID);
  $stmt->bindValue(':originlocation', $OriginLocation);
  $stmt->bindValue(':destinationlocation',  $DestinationLocation);

  $result = $stmt->execute();

  if ($result) {
    echo "SUCCESS_GET";
  } else {
    echo "ERROR_GET";
    return;
  }

  if ($stmt->fetch()) {
    // RECORD EXISTS
    $Exists = true;
    RemoveFromFavourites();
  } else {
    // RECORD DOESNT EXIST
    $Exists = false;
    AddToFavourites();
  }
}

function AddToFavourites() {

  global $EditType, $Exists, $db, $UserID, $OriginLocation, $DestinationLocation;

  if ($EditType == "add") {
    if ($Exists) {
      echo "Already added";
      return;
    } else {

      $sql = "INSERT INTO favourites (User_ID, origin_location, destination_location) VALUES (:userid, :originlocation, :destinationlocation)";
      $stmt = $db->prepare($sql);

      $stmt->bindValue(':userid', $UserID);
      $stmt->bindValue(':originlocation', $OriginLocation);
      $stmt->bindValue('destinationlocation', $DestinationLocation);

      $result = $stmt->execute();

      if ($result) {
        echo "SUCCESS_ADD";
      } else {
        echo "ERR_ADD";
        return;
      }

    }
  }

}

function RemoveFromFavourites() {

  global $EditType, $Exists, $db, $UserID, $OriginLocation, $DestinationLocation;

  if ($EditType == "remove") {
    if ($Exists) {

      $sql = "DELETE FROM favourites WHERE User_ID = :userid AND origin_location = :originlocation AND destination_location = :destinationlocation";
      $stmt = $db->prepare($sql);

      $stmt->bindValue(':userid', $UserID);
      $stmt->bindValue(':originlocation', $OriginLocation);
      $stmt->bindValue(':destinationlocation', $DestinationLocation);

      $result = $stmt->execute();

      if ($result) {
        echo "SUCCESS_REMOVE";
      } else {
        echo "ERR_REMOVE";
        return;
      }

    } else {
      echo "Never existed";
      return;
    }
  }

}

?>
