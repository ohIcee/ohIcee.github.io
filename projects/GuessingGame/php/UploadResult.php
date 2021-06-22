<?php

$AmountOfTries = $_POST["AmountOfTries"];
$GuessTime = $_POST["GuessTime"];
$Name = $_POST["Name"];

$user = 'root';
$pass = 'IEtAElB0Xe3g9Pe0';
$db = new PDO( 'mysql:host=localhost;dbname=NIRSA_GuessingGame', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );

$sql = "INSERT INTO results (Name, GuessTime, Tries) VALUES (:name, :guesstime, :tries)";
$stmt = $db->prepare($sql);

$stmt->bindValue(":name", $Name);
$stmt->bindValue(":guesstime", $GuessTime);
$stmt->bindValue(":tries", $AmountOfTries);

$result = $stmt->execute();

if ($result) {
  echo "SUCCESS_INSERT";
} else {
  echo "ERR_INSERT";
}

?>
