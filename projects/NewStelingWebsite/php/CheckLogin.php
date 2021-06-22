<?php
session_start();

require('DBConnect.php');
$Email = $_SESSION['email'];
$query = "SELECT * from users WHERE email='$Email'";
$result = $db->query($query);
if($result->num_rows === 0) {
  $_SESSION['email'] = null;
}

mysqli_close($db);
?>
