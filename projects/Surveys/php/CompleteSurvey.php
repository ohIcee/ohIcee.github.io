<?php

$user = 'root';
$pass = 'IEtAElB0Xe3g9Pe0';
$db = new PDO( 'mysql:host=localhost;dbname=Survey', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );

$SurveyName = $_POST['surveyName'];
// $SurveyAuthor = $_POST['surveyAuthor'];
$SurveyInfoJSON = $_POST['surveyInfoJSON'];

$sql = "INSERT INTO Surveys (Name, info) VALUES (:surveyname, :surveyinfo)";
$stmt = $db->prepare($sql);

$stmt->bindValue(":surveyname", $SurveyName);
$stmt->bindValue(":surveyinfo", $SurveyInfoJSON);

$result = $stmt->execute();
if ($result) {
  echo "SUCCESS_INSERT";
} else {
  echo "ERR_INSERT";
}

?>
