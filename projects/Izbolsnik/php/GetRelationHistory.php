<?php

session_start();

if (!isset($_SESSION["user_id"])) {
  die("Not logged in!");
  return;
}

require_once('DBConnect.php');

$user = 'root';
$pass = 'IEtAElB0Xe3g9Pe0';
$db = new PDO( 'mysql:host=localhost;dbname=izbolsnik', $user, $pass );

$sql = "SELECT origin_location, destination_location, date_searched FROM relationHistory WHERE User_ID = :userid";
$stmt = $db->prepare($sql);

$stmt->bindValue(':userid', $_SESSION['user_id']);
$stmt->execute();

$rows = $stmt->fetchAll();

foreach ($rows as $row) {
  echo $row['origin_location'] . "_" . $row['destination_location'] . "_" . $row['date_searched'] . "|";
}

?>
