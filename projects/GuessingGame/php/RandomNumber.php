<?php
session_start();
echo session_status() == 2
  ? $_SESSION["NumberToGuess"]
  : "ERROR_NO_SESSION";
?>
