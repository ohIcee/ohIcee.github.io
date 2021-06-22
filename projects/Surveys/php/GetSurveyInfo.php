<?php

$user = 'root';
$pass = 'IEtAElB0Xe3g9Pe0';
$db = new PDO( 'mysql:host=localhost;dbname=Survey', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );

$SurveyID = $_GET['surveyID'];

$sql = "SELECT info FROM Surveys WHERE ID = :SurveyID";
$stmt = $db->prepare($sql);

$stmt->bindValue(':SurveyID', $SurveyID);
$stmt->execute();

$results = $stmt->fetch(PDO::FETCH_ASSOC);
$json = json_encode($results);
echo $json;

?>
