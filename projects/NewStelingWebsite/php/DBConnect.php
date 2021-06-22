<?php

$S = 'localhost'; /* SERVER IP */
$U = 'root'; /* USERNAME FOR phpMyAdmin */
$P = 'IEtAElB0Xe3g9Pe0'; /* PASSWORD FOR phpMyAdmin */
$DBName = 'StelingWebsite';

//connection to the database
$db = mysqli_connect($S, $U, $P, $DBName)
 or die('Error connecting to MySQL server.');

?>
