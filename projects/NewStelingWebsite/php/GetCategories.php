<?php

  require('DBConnect.php');

  $categoryIDs = array();
  $categoryNames = array();

  $stmt = $db->prepare("SELECT ID, name FROM categories");
  $stmt->bind_param('in', $ID, $name);
  $stmt->execute();
  mysqli_stmt_bind_result($stmt, $ID, $name);
  while (mysqli_stmt_fetch($stmt)) {
    array_push($categoryIDs, $ID);
    array_push($categoryNames, $name);
    echo $ID . "/" . $name . " ";
  }
  mysqli_stmt_close($stmt);



?>
