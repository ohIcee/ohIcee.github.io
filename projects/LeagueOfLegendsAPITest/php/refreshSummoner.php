<?php

session_start();
$apiKey = 'RGAPI-fe446e76-1c8d-467a-874c-e7b85448ae64';

$val = $_POST['summNameInput'];
$val = strtolower($val);

echo "Getting user information...";

if ($val != "refresh") {
  // NEW SUMMONER
  $summonerName = $val;
  $_SESSION['currSumm'] = $val;
  newSumm($summonerName, $apiKey);
} else {
  // OLD SUMMONER REFRESH
  $summonerName = $_SESSION['currSumm'];
  oldSum($summonerName, $apiKey);
}

function newSumm($summ, $api) {
echo $summ . " \ new summ";
  try {
    $result = file_get_contents('https://euw.api.pvp.net/api/lol/EUW/v1.4/summoner/by-name/' . $summ . '?api_key=' . $api);
    $summoner = json_decode($result)->$summ;
  } catch (Exception $e) {
    echo "Failed to retrieve summoner. ERROR " . $e;
  }


  if($summoner != null || $summoner != 0) {

    $_SESSION['summ'] = $summoner;
    $_SESSION['summName'] = $summ;
    $_SESSION['APIKey'] = $api;
    echo "Done!";

  }
}

function oldSum($summ, $api) {
  echo $summ . " \ old summ";
  $_SESSION['currSum'] = $summ;
  try {
    $result = file_get_contents('https://euw.api.pvp.net/api/lol/EUW/v1.4/summoner/by-name/' . $summ . '?api_key=' . $api);
    $summoner = json_decode($result)->$summ;
  } catch (Exception $e) {
    echo "Failed to retrieve summoner. ERROR " . $e;
  }

  if($summoner != null || $summoner != 0) {

    $_SESSION['summ'] = $summoner;
    $_SESSION['summName'] = $summ;
    $_SESSION['APIKey'] = $api;
    echo "Done!";

  }
}

 ?>
