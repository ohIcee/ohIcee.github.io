<?php

session_start();

$user = 'root';
$pass = 'IEtAElB0Xe3g9Pe0';
$db = new PDO( 'mysql:host=localhost;dbname=Dripp', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4") );

?>
