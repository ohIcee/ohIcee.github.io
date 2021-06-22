<?php

require('DBConnect.php');

$imageNames = array();
$imageCategoryIDs = array();

$stmt = $db->prepare("SELECT name, category_id FROM images");
$stmt->bind_param('nc', $name, $categoryID);
$stmt->execute();
mysqli_stmt_bind_result($stmt, $name, $categoryID);
while (mysqli_stmt_fetch($stmt)) {
  array_push($imageNames, $name);
  array_push($imageCategoryIDs, $categoryID);
  echo $categoryID . "/" . $name . " ";
}
mysqli_stmt_close($stmt);

?>
