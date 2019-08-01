<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$jsonFile = file_get_contents('stations.json');
$ye = json_decode($jsonFile, true);

// echo $jsonFile;

// echo $ye;

$locations = [];

for ($i=0; $i < count($ye); $i++) {
  array_push($locations, $ye[$i]['location']);
}

$newJSON = json_encode($locations);
echo $newJSON;


?>
