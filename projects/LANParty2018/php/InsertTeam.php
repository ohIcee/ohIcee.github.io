<?php

$TeamName = $_POST['teamname'];
$TeamTag = $_POST['teamtag'];
$TeamID = null;
$Players = $_POST['players'];
$Players = json_decode($Players, true);

require_once('DBConnect.php');

function CheckSignups() {
  global $db;

  $stmt = $db->prepare("SELECT COUNT(*) FROM teams WHERE game=:game");
  $stmt->bindValue(":game", $_POST['selectedgame']);
  $stmt->execute();
  $count = $stmt->fetchColumn();

  if ($_POST['selectedgame'] == 'csgo' && $count < 8) {
    return true;
  }

  if ($_POST['selectedgame'] == 'league' && $count < 16) {
    return true;
  }

  echo "ERR_SIGNUPS_FULL";
  return false;
}

function InsertTeam() {
  global $db, $TeamID, $TeamName, $TeamTag;

  $sql = "INSERT INTO teams (name, tag, game) VALUES (:name, :tag, :game)";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":name", $TeamName);
  $stmt->bindValue(":tag", $TeamTag);
  $stmt->bindValue(":game", $_POST['selectedgame']);
  $result = $stmt->execute();
  $TeamID = $db->lastInsertId();
  if (!$result) {
    echo "ERR_INSERT_TEAM";
    exit();
  }
}

function InsertPlayers() {
  global $db, $TeamID, $Players;

  $stmt = $db->prepare("INSERT INTO players (name, school, email, teamID) VALUES
  (:p1_n, :p1_s, :p1_e, :id),
  (:p2_n, :p2_s, :p2_e, :id),
  (:p3_n, :p3_s, :p3_e, :id),
  (:p4_n, :p4_s, :p4_e, :id),
  (:p5_n, :p5_s, :p5_e, :id)");
  $stmt->bindValue(':id', $TeamID);
  $stmt->bindValue(':p1_n', $Players[0]['FullName']);
  $stmt->bindValue(':p1_s', $Players[0]['School']);
  $stmt->bindValue(':p1_e', $Players[0]['Email']);
  $stmt->bindValue(':p2_n', $Players[1]['FullName']);
  $stmt->bindValue(':p2_s', $Players[1]['School']);
  $stmt->bindValue(':p2_e', $Players[1]['Email']);
  $stmt->bindValue(':p3_n', $Players[2]['FullName']);
  $stmt->bindValue(':p3_s', $Players[2]['School']);
  $stmt->bindValue(':p3_e', $Players[2]['Email']);
  $stmt->bindValue(':p4_n', $Players[3]['FullName']);
  $stmt->bindValue(':p4_s', $Players[3]['School']);
  $stmt->bindValue(':p4_e', $Players[3]['Email']);
  $stmt->bindValue(':p5_n', $Players[4]['FullName']);
  $stmt->bindValue(':p5_s', $Players[4]['School']);
  $stmt->bindValue(':p5_e', $Players[4]['Email']);
  $result = $stmt->execute();
  if (!$result) {
    echo "ERR_INSERT_USERS";
    $result = $db->prepare("DELETE FROM teams WHERE id=" . $TeamID)->execute();
  } else {
    echo "SUCCESS_SIGNUP";
  }
}

if (CheckSignups()) {
  InsertTeam();
  InsertPlayers();
}

?>
