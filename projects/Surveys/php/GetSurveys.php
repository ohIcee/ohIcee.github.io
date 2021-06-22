<?php

$user = 'root';
$pass = 'IEtAElB0Xe3g9Pe0';
$db = new PDO( 'mysql:host=localhost;dbname=Survey', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );

$sql = "SELECT ID, Name, Author FROM Surveys";
$stmt = $db->prepare($sql);

$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($results);
echo $json;

?>
