<?php

$user = 'root';
$pass = 'IEtAElB0Xe3g9Pe0';
$db = new PDO( 'mysql:host=localhost;dbname=Survey', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );

$SurveyID = $_POST['surveyID'];
$SurveyInfoJSON = $_POST['SurveyInfoJSON'];

$sql = "INSERT INTO SurveyAnswers (SurveyID, answers) VALUES (:surveyID, :Answers)";
$stmt = $db->prepare($sql);

$stmt->bindValue(":surveyID", intval($SurveyID));
$stmt->bindValue(":Answers", $SurveyInfoJSON);

$result = $stmt->execute();
if ($result) {
  echo "SUCCESS_INSERT";
} else {
  echo "ERR_INSERT";
}

?>
