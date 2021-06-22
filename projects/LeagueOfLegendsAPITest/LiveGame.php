<head>

<?php
session_start();

//error_reporting(E_ERROR | E_PARSE);
if ($_SESSION['APIKey']) {
  $apiKey = $_SESSION['APIKey'];
} else {
  header("Location: Error.php");
  exit();
}

  if($_SESSION['championInformation'] == null) {

    $url = 'https://global.api.riotgames.com/api/lol/static-data/EUW/v1.2/champion/?api_key=' . $_SESSION["APIKey"];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    $championInformationJSON = curl_exec($ch);
    curl_close($ch);
    $championInformation = json_decode($championInformationJSON, true);
    $_SESSION['championInformation'] = $championInformation;

  }

  if($_SESSION['SummonerSpellData'] == null) {

    $url = 'https://global.api.riotgames.com/api/lol/static-data/EUW/v1.2/summoner-spell/?api_key=' . $_SESSION["APIKey"];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    $SummonerSpellDataJSON = curl_exec($ch);
    curl_close($ch);
    $SummonerSpellData = json_decode($SummonerSpellDataJSON, true);
    $_SESSION['SummonerSpellData'] = $SummonerSpellData;

  }

  $url = 'https://euw.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/EUW1/' . $_SESSION['summ']->id . '?api_key=' . $apiKey;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
  $LiveGameInfoJSON = curl_exec($ch);
  curl_close($ch);

  if($_SESSION['SummonerSpells'] == null) {

    $url = 'http://ddragon.leagueoflegends.com/cdn/6.24.1/data/en_US/summoner.json';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    $SummonerSpellsJSON = curl_exec($ch);
    curl_close($ch);
    $SummonerSpells = json_decode($SummonerSpellsJSON, true);
    $_SESSION['SummonerSpells'] = $SummonerSpells;

  }

  if($_SESSION['MapInformationDATA'] == null) {

    $url = 'https://global.api.riotgames.com/api/lol/static-data/EUW/v1.2/map?api_key=' . $_SESSION['APIKey'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    $MapInformationJSON = curl_exec($ch);
    curl_close($ch);
    $MapInformation = json_decode($MapInformationJSON, true);
    $_SESSION['MapInformationDATA'] = $MapInformation["data"];

  }

 ?>

  <title>LOL_API_TEST</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/LiveGame_design.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <meta name="viewport" content="initial-scale=1, maximum-scale=1">

</head>
<body>

<div class="IndexLayoutWrap">

  <nav>
    <div class="nav-wrapper" style="background-color: #3498db">
      <form>
        <div class="input-field">
          <input placeholder="SEARCH EUW" id="search" type="search" required>
        </div>
      </form>
    </div>
  </nav>

<div class="WebsiteContent">
  <div class="userSTATS_Start">
      <div class="userLiveGAMEInformation">
        <?php

        if($LiveGameInfoJSON != null) {

        $LiveGameInfo = json_decode($LiveGameInfoJSON);
        $LiveGameID = $LiveGameInfo->gameId;
        $LiveGameDuration = $LiveGameInfo->gameLength;
        $LiveGameMapID = $LiveGameInfo->mapId;
        $LiveGameParticipants = $LiveGameInfo->participants;

        //$LiveGameQueueConfigId = $LiveGameInfo->gameQueueConfigId;
        if($LiveGameInfo->gameQueueConfigId != null) {
          $LiveGameQueueConfigName = getQueueConfigIdName($LiveGameInfo->gameQueueConfigId);
        } else {
          $LiveGameQueueConfigName = 'CUSTOM GAME';
        }
        $MapName = getMapName($LiveGameMapID);

        $LiveGameParticipant1 = $LiveGameParticipants[0];
        $LiveGameParticipant1_ChampionId = $LiveGameParticipant1->championId;
        $LiveGameParticipant1_SummonerName = $LiveGameParticipant1->summonerName;
        $LiveGameParticipant1_ChampionName = getChampionName($LiveGameParticipant1_ChampionId);
        $LiveGameParticipant1_Spell1Id = $LiveGameParticipant1->spell1Id;
        $LiveGameParticipant1_Spell2Id = $LiveGameParticipant1->spell2Id;
        $LiveGameParticipant1_Spell1Icon = getSpellIcon($LiveGameParticipant1_Spell1Id);
        $LiveGameParticipant1_Spell2Icon = getSpellIcon($LiveGameParticipant1_Spell2Id);
        $LiveGameParticipant1_Spell1Name = getSpellName($LiveGameParticipant1_Spell1Id);
        $LiveGameParticipant1_Spell2Name = getSpellName($LiveGameParticipant1_Spell2Id);
        $LiveGameParticipant1_ChampionIcon = getChampionIcon($LiveGameParticipant1_ChampionName);
        $LiveGameParticipant1_ELOTier = null;
        $LiveGameParticipant1_ELODivision = null;
        getELO($LiveGameParticipant1->summonerId, $LiveGameParticipant1_ELOTier, $LiveGameParticipant1_ELODivision);

        $LiveGameParticipant2 = $LiveGameParticipants[1];
        $LiveGameParticipant2_SummonerName = $LiveGameParticipant2->summonerName;
        $LiveGameParticipant2_ChampionName = getChampionName($LiveGameParticipant2->championId);
        $LiveGameParticipant2_Spell1Id = $LiveGameParticipant2->spell1Id;
        $LiveGameParticipant2_Spell2Id = $LiveGameParticipant2->spell2Id;
        $LiveGameParticipant2_Spell1Icon = getSpellIcon($LiveGameParticipant2_Spell1Id);
        $LiveGameParticipant2_Spell2Icon = getSpellIcon($LiveGameParticipant2_Spell2Id);
        $LiveGameParticipant2_Spell1Name = getSpellName($LiveGameParticipant2_Spell1Id);
        $LiveGameParticipant2_Spell2Name = getSpellName($LiveGameParticipant2_Spell2Id);
        $LiveGameParticipant2_ChampionIcon = getChampionIcon($LiveGameParticipant2_ChampionName);
        $LiveGameParticipant2_ELOTier = null;
        $LiveGameParticipant2_ELODivision = null;
        getELO($LiveGameParticipant2->summonerId, $LiveGameParticipant2_ELOTier, $LiveGameParticipant2_ELODivision);

        $LiveGameParticipant3 = $LiveGameParticipants[2];
        $LiveGameParticipant3_SummonerName = $LiveGameParticipant3->summonerName;
        $LiveGameParticipant3_ChampionName = getChampionName($LiveGameParticipant3->championId);
        $LiveGameParticipant3_Spell1Id = $LiveGameParticipant3->spell1Id;
        $LiveGameParticipant3_Spell2Id = $LiveGameParticipant3->spell2Id;
        $LiveGameParticipant3_Spell1Icon = getSpellIcon($LiveGameParticipant3_Spell1Id);
        $LiveGameParticipant3_Spell2Icon = getSpellIcon($LiveGameParticipant3_Spell2Id);
        $LiveGameParticipant3_Spell1Name = getSpellName($LiveGameParticipant3_Spell1Id);
        $LiveGameParticipant3_Spell2Name = getSpellName($LiveGameParticipant3_Spell2Id);
        $LiveGameParticipant3_ChampionIcon = getChampionIcon($LiveGameParticipant3_ChampionName);
        $LiveGameParticipant3_ELOTier = null;
        $LiveGameParticipant3_ELODivision = null;
        getELO($LiveGameParticipant3->summonerId, $LiveGameParticipant3_ELOTier, $LiveGameParticipant3_ELODivision);

        $LiveGameParticipant4 = $LiveGameParticipants[3];
        $LiveGameParticipant4_SummonerName = $LiveGameParticipant4->summonerName;
        $LiveGameParticipant4_ChampionName = getChampionName($LiveGameParticipant4->championId);
        $LiveGameParticipant4_Spell1Id = $LiveGameParticipant4->spell1Id;
        $LiveGameParticipant4_Spell2Id = $LiveGameParticipant4->spell2Id;
        $LiveGameParticipant4_Spell1Icon = getSpellIcon($LiveGameParticipant4_Spell1Id);
        $LiveGameParticipant4_Spell2Icon = getSpellIcon($LiveGameParticipant4_Spell2Id);
        $LiveGameParticipant4_Spell1Name = getSpellName($LiveGameParticipant4_Spell1Id);
        $LiveGameParticipant4_Spell2Name = getSpellName($LiveGameParticipant4_Spell2Id);
        $LiveGameParticipant4_ChampionIcon = getChampionIcon($LiveGameParticipant4_ChampionName);
        $LiveGameParticipant4_ELOTier = null;
        $LiveGameParticipant4_ELODivision = null;
        getELO($LiveGameParticipant4->summonerId, $LiveGameParticipant4_ELOTier, $LiveGameParticipant4_ELODivision);

        $LiveGameParticipant5 = $LiveGameParticipants[4];
        $LiveGameParticipant5_SummonerName = $LiveGameParticipant5->summonerName;
        $LiveGameParticipant5_ChampionName = getChampionName($LiveGameParticipant5->championId);
        $LiveGameParticipant5_Spell1Id = $LiveGameParticipant5->spell1Id;
        $LiveGameParticipant5_Spell2Id = $LiveGameParticipant5->spell2Id;
        $LiveGameParticipant5_Spell1Icon = getSpellIcon($LiveGameParticipant5_Spell1Id);
        $LiveGameParticipant5_Spell2Icon = getSpellIcon($LiveGameParticipant5_Spell2Id);
        $LiveGameParticipant5_Spell1Name = getSpellName($LiveGameParticipant5_Spell1Id);
        $LiveGameParticipant5_Spell2Name = getSpellName($LiveGameParticipant5_Spell2Id);
        $LiveGameParticipant5_ChampionIcon = getChampionIcon($LiveGameParticipant5_ChampionName);
        $LiveGameParticipant5_ELOTier = null;
        $LiveGameParticipant5_ELODivision = null;
        getELO($LiveGameParticipant5->summonerId, $LiveGameParticipant5_ELOTier, $LiveGameParticipant5_ELODivision);

        $LiveGameParticipant6 = $LiveGameParticipants[5];
        $LiveGameParticipant6_SummonerName = $LiveGameParticipant6->summonerName;
        $LiveGameParticipant6_ChampionName = getChampionName($LiveGameParticipants[5]->championId);
        $LiveGameParticipant6_Spell1Id = $LiveGameParticipant6->spell1Id;
        $LiveGameParticipant6_Spell2Id = $LiveGameParticipant6->spell2Id;
        $LiveGameParticipant6_Spell1Icon = getSpellIcon($LiveGameParticipant6_Spell1Id);
        $LiveGameParticipant6_Spell2Icon = getSpellIcon($LiveGameParticipant6_Spell2Id);
        $LiveGameParticipant6_Spell1Name = getSpellName($LiveGameParticipant6_Spell1Id);
        $LiveGameParticipant6_Spell2Name = getSpellName($LiveGameParticipant6_Spell2Id);
        $LiveGameParticipant6_ChampionIcon = getChampionIcon($LiveGameParticipant6_ChampionName);
        $LiveGameParticipant6_ELOTier = null;
        $LiveGameParticipant6_ELODivision = null;
        getELO($LiveGameParticipant6->summonerId, $LiveGameParticipant6_ELOTier, $LiveGameParticipant6_ELODivision);

        $LiveGameParticipant7 = $LiveGameParticipants[6];
        $LiveGameParticipant7_SummonerName = $LiveGameParticipant7->summonerName;
        $LiveGameParticipant7_ChampionName = getChampionName($LiveGameParticipants[6]->championId);
        $LiveGameParticipant7_Spell1Id = $LiveGameParticipant7->spell1Id;
        $LiveGameParticipant7_Spell2Id = $LiveGameParticipant7->spell2Id;
        $LiveGameParticipant7_Spell1Icon = getSpellIcon($LiveGameParticipant7_Spell1Id);
        $LiveGameParticipant7_Spell2Icon = getSpellIcon($LiveGameParticipant7_Spell2Id);
        $LiveGameParticipant7_Spell1Name = getSpellName($LiveGameParticipant7_Spell1Id);
        $LiveGameParticipant7_Spell2Name = getSpellName($LiveGameParticipant7_Spell2Id);
        $LiveGameParticipant7_ChampionIcon = getChampionIcon($LiveGameParticipant7_ChampionName);
        $LiveGameParticipant7_ELOTier = null;
        $LiveGameParticipant7_ELODivision = null;
        getELO($LiveGameParticipant7->summonerId, $LiveGameParticipant7_ELOTier, $LiveGameParticipant7_ELODivision);

        $LiveGameParticipant8 = $LiveGameParticipants[7];
        $LiveGameParticipant8_SummonerName = $LiveGameParticipant8->summonerName;
        $LiveGameParticipant8_ChampionName = getChampionName($LiveGameParticipants[7]->championId);
        $LiveGameParticipant8_Spell1Id = $LiveGameParticipant8->spell1Id;
        $LiveGameParticipant8_Spell2Id = $LiveGameParticipant8->spell2Id;
        $LiveGameParticipant8_Spell1Icon = getSpellIcon($LiveGameParticipant8_Spell1Id);
        $LiveGameParticipant8_Spell2Icon = getSpellIcon($LiveGameParticipant8_Spell2Id);
        $LiveGameParticipant8_Spell1Name = getSpellName($LiveGameParticipant8_Spell1Id);
        $LiveGameParticipant8_Spell2Name = getSpellName($LiveGameParticipant8_Spell2Id);
        $LiveGameParticipant8_ChampionIcon = getChampionIcon($LiveGameParticipant8_ChampionName);
        $LiveGameParticipant8_ELOTier = null;
        $LiveGameParticipant8_ELODivision = null;
        getELO($LiveGameParticipant8->summonerId, $LiveGameParticipant8_ELOTier, $LiveGameParticipant8_ELODivision);

        $LiveGameParticipant9 = $LiveGameParticipants[8];
        $LiveGameParticipant9_SummonerName = $LiveGameParticipant9->summonerName;
        $LiveGameParticipant9_ChampionName = getChampionName($LiveGameParticipant9->championId);
        $LiveGameParticipant9_Spell1Id = $LiveGameParticipant9->spell1Id;
        $LiveGameParticipant9_Spell2Id = $LiveGameParticipant9->spell2Id;
        $LiveGameParticipant9_Spell1Icon = getSpellIcon($LiveGameParticipant9_Spell1Id);
        $LiveGameParticipant9_Spell2Icon = getSpellIcon($LiveGameParticipant9_Spell2Id);
        $LiveGameParticipant9_Spell1Name = getSpellName($LiveGameParticipant9_Spell1Id);
        $LiveGameParticipant9_Spell2Name = getSpellName($LiveGameParticipant9_Spell2Id);
        $LiveGameParticipant9_ChampionIcon = getChampionIcon($LiveGameParticipant9_ChampionName);
        $LiveGameParticipant9_ELOTier = null;
        $LiveGameParticipant9_ELODivision = null;
        getELO($LiveGameParticipant9->summonerId, $LiveGameParticipant9_ELOTier, $LiveGameParticipant9_ELODivision);

        $LiveGameParticipant10 = $LiveGameParticipants[9];
        $LiveGameParticipant10_SummonerName = $LiveGameParticipant10->summonerName;
        $LiveGameParticipant10_ChampionName = getChampionName($LiveGameParticipants[9]->championId);
        $LiveGameParticipant10_Spell1Id = $LiveGameParticipant10->spell1Id;
        $LiveGameParticipant10_Spell2Id = $LiveGameParticipant10->spell2Id;
        $LiveGameParticipant10_Spell1Icon = getSpellIcon($LiveGameParticipant10_Spell1Id);
        $LiveGameParticipant10_Spell2Icon = getSpellIcon($LiveGameParticipant10_Spell2Id);
        $LiveGameParticipant10_Spell1Name = getSpellName($LiveGameParticipant10_Spell1Id);
        $LiveGameParticipant10_Spell2Name = getSpellName($LiveGameParticipant10_Spell2Id);
        $LiveGameParticipant10_ChampionIcon = getChampionIcon($LiveGameParticipant10_ChampionName);
        $LiveGameParticipant10_ELOTier = null;
        $LiveGameParticipant10_ELODivision = null;
        getELO($LiveGameParticipant10->summonerId, $LiveGameParticipant10_ELOTier, $LiveGameParticipant10_ELODivision);

      } else {

        $LiveGameID = null;
        $LiveGameDuration = 0;
        $GamemodeName = 'none';
        $MapName = 'none';
        $LiveGameParticipant1_SummonerName = '';
        $LiveGameParticipant1_ChampionName = '';
        $LiveGameParticipant2_SummonerName = '';
        $LiveGameParticipant2_ChampionName = '';
        $LiveGameParticipant3_SummonerName = '';
        $LiveGameParticipant3_ChampionName = '';
        $LiveGameParticipant4_SummonerName = '';
        $LiveGameParticipant4_ChampionName = '';
        $LiveGameParticipant5_SummonerName = '';
        $LiveGameParticipant5_ChampionName = '';
        $LiveGameParticipant6_SummonerName = '';
        $LiveGameParticipant6_ChampionName = '';
        $LiveGameParticipant7_SummonerName = '';
        $LiveGameParticipant7_ChampionName = '';
        $LiveGameParticipant8_SummonerName = '';
        $LiveGameParticipant8_ChampionName = '';
        $LiveGameParticipant9_SummonerName = '';
        $LiveGameParticipant9_ChampionName = '';
        $LiveGameParticipant10_SummonerName = '';
        $LiveGameParticipant10_ChampionName = '';

      }
?>

        <h1 style="font-weight:bold;">LIVE GAME <span style="font-size: 15px;"><span style="color: green; font-style: italic;">ID_</span><span style="color: green; font-style: italic;"><?php print $LiveGameID ?></span></span></h1>
        <div class="infoRow"> <span> PLAYING <span style="font-weight: bold;">
         <?php print $LiveGameQueueConfigName; ?> <span style="font-weight: normal;"> ON <span style="font-weight: bold;"> <?php print $MapName; ?> </span>
        </span> </span> </span>

        </div>
        <div class="infoRow">
          <span> GAME DURATION approx.
            <span id="gameDurationText" style="font-weight: bold;"> // GAME DURATION  </span>
            <span id="gameDurationHint"> - DOESNT REFRESH AFTER GAME IS FINISHED</span>
          </span>
        </div>
		
		<div class="LiveGamePlayersWrapper">
		</div>
		
        <div class="liveGamePlayerBorder" id="LiveGamePlayersBorder">
          <div class="liveGamePlayersLeft">
            <div class = "LiveGamePlayerRow" id="bluePlayerRow">
              <div class="row">
                <div class="col s3">
                  <div class="LiveGamePlayerSummonerSpellsRow" id="blueSummonerRow">
                   <img src="<?php print $LiveGameParticipant1_Spell1Icon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant1_Spell1Name ?>" class="LiveGamePlayerSummSpell tooltipped"></img>
                   <img src="<?php print $LiveGameParticipant1_Spell2Icon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant1_Spell2Name ?>" class="LiveGamePlayerSummSpell tooltipped"></img>
                 </div>
                </div>
                <div class="col s4 LiveGamePlayerName">
                  <span class="LiveGamePlayerSummonerName"><?php print $LiveGameParticipant1_SummonerName ?></span>
                </div>
                <div class="col s4 LiveGamePlayerChampion">
                  <img src="<?php print $LiveGameParticipant1_ChampionIcon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant1_ChampionName ?>" class="LiveGamePlayerChampionImage tooltipped"></img>
                </div>
              </div>
            </div>

            <div class = "LiveGamePlayerRow" id="bluePlayerRow">
              <div class="row">
                <div class="col s3">
                  <div class="LiveGamePlayerSummonerSpellsRow" id="blueSummonerRow">
                    <img src="<?php print $LiveGameParticipant2_Spell1Icon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant2_Spell1Name ?>" class="LiveGamePlayerSummSpell tooltipped"></img>
                    <img src="<?php print $LiveGameParticipant2_Spell2Icon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant2_Spell2Name ?>" class="LiveGamePlayerSummSpell tooltipped"></img>
                 </div>
                </div>
                <div class="col s4 LiveGamePlayerName">
                  <span class="LiveGamePlayerSummonerName"><?php print $LiveGameParticipant2_SummonerName ?></span>
                </div>
                <div class="col s4 LiveGamePlayerChampion">
                  <img src="<?php print $LiveGameParticipant2_ChampionIcon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant2_ChampionName ?>" class="LiveGamePlayerChampionImage tooltipped"></img>
                </div>
              </div>
            </div>

            <div class = "LiveGamePlayerRow" id="bluePlayerRow">
              <div class="row">
                <div class="col s3">
                  <div class="LiveGamePlayerSummonerSpellsRow" id="blueSummonerRow">
                    <img src="<?php print $LiveGameParticipant3_Spell1Icon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant3_Spell1Name ?>" class="LiveGamePlayerSummSpell tooltipped"></img>
                    <img src="<?php print $LiveGameParticipant3_Spell2Icon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant3_Spell2Name ?>" class="LiveGamePlayerSummSpell tooltipped"></img>
                 </div>
                </div>
                <div class="col s4 LiveGamePlayerName">
                  <span class="LiveGamePlayerSummonerName"><?php print $LiveGameParticipant3_SummonerName ?></span>
                </div>
                <div class="col s4 LiveGamePlayerChampion">
                  <img src="<?php print $LiveGameParticipant3_ChampionIcon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant3_ChampionName ?>" class="LiveGamePlayerChampionImage tooltipped"></img>
                </div>
              </div>
            </div>

            <div class = "LiveGamePlayerRow" id="bluePlayerRow">
              <div class="row">
                <div class="col s3">
                  <div class="LiveGamePlayerSummonerSpellsRow" id="blueSummonerRow">
                    <img src="<?php print $LiveGameParticipant4_Spell1Icon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant4_Spell1Name ?>" class="LiveGamePlayerSummSpell tooltipped"></img>
                    <img src="<?php print $LiveGameParticipant4_Spell2Icon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant4_Spell2Name ?>" class="LiveGamePlayerSummSpell tooltipped"></img>
                 </div>
                </div>
                <div class="col s4 LiveGamePlayerName">
                  <span class="LiveGamePlayerSummonerName"><?php print $LiveGameParticipant4_SummonerName ?></span>
                </div>
                <div class="col s4 LiveGamePlayerChampion">
                  <img src="<?php print $LiveGameParticipant4_ChampionIcon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant4_ChampionName ?>" class="LiveGamePlayerChampionImage tooltipped"></img>
                </div>
              </div>
            </div>

            <div class = "LiveGamePlayerRow" id="bluePlayerRow">
              <div class="row">
                <div class="col s3">
                  <div class="LiveGamePlayerSummonerSpellsRow" id="blueSummonerRow">
                    <img src="<?php print $LiveGameParticipant5_Spell1Icon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant5_Spell1Name ?>" class="LiveGamePlayerSummSpell tooltipped"></img>
                    <img src="<?php print $LiveGameParticipant5_Spell2Icon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant5_Spell2Name ?>" class="LiveGamePlayerSummSpell tooltipped"></img>
                 </div>
                </div>
                <div class="col s4 LiveGamePlayerName">
                  <span class="LiveGamePlayerSummonerName"><?php print $LiveGameParticipant5_SummonerName ?></span>
                </div>
                <div class="col s4 LiveGamePlayerChampion">
                  <img src="<?php print $LiveGameParticipant5_ChampionIcon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant5_ChampionName ?>" class="LiveGamePlayerChampionImage tooltipped"></img>
                </div>
              </div>
            </div>
          </div>

          <div class="liveGamePlayersRight">

            <div class = "LiveGamePlayerRow" id="redPlayerRow">
              <div class="row">
                <div class="col s3">
                  <div class="LiveGamePlayerSummonerSpellsRow" id="redSummonerRow">
                    <img src="<?php print $LiveGameParticipant6_Spell1Icon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant6_Spell1Name ?>" class="LiveGamePlayerSummSpell tooltipped"></img>
                    <img src="<?php print $LiveGameParticipant6_Spell2Icon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant6_Spell2Name ?>" class="LiveGamePlayerSummSpell tooltipped"></img>
                 </div>
                </div>
                <div class="col s4 LiveGamePlayerName">
                  <span class="LiveGamePlayerSummonerName"><?php print $LiveGameParticipant6_SummonerName ?></span>
                </div>
                <div class="col s4 LiveGamePlayerChampion">
                  <img src="<?php print $LiveGameParticipant6_ChampionIcon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant6_ChampionName ?>" class="LiveGamePlayerChampionImage tooltipped"></img>
                </div>
              </div>
            </div>

            <div class = "LiveGamePlayerRow" id="redPlayerRow">
              <div class="row">
                <div class="col s3">
                  <div class="LiveGamePlayerSummonerSpellsRow" id="redSummonerRow">
                    <img src="<?php print $LiveGameParticipant7_Spell1Icon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant7_Spell1Name ?>" class="LiveGamePlayerSummSpell tooltipped"></img>
                    <img src="<?php print $LiveGameParticipant7_Spell2Icon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant7_Spell2Name ?>" class="LiveGamePlayerSummSpell tooltipped"></img>
                 </div>
                </div>
                <div class="col s4 LiveGamePlayerName">
                  <span class="LiveGamePlayerSummonerName"><?php print $LiveGameParticipant7_SummonerName ?></span>
                </div>
                <div class="col s4 LiveGamePlayerChampion">
                  <img src="<?php print $LiveGameParticipant7_ChampionIcon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant7_ChampionName ?>" class="LiveGamePlayerChampionImage tooltipped"></img>
                </div>
              </div>
            </div>

            <div class = "LiveGamePlayerRow" id="redPlayerRow">
              <div class="row">
                <div class="col s3">
                  <div class="LiveGamePlayerSummonerSpellsRow" id="redSummonerRow">
                    <img src="<?php print $LiveGameParticipant8_Spell1Icon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant8_Spell1Name ?>" class="LiveGamePlayerSummSpell tooltipped"></img>
                    <img src="<?php print $LiveGameParticipant8_Spell2Icon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant8_Spell2Name ?>" class="LiveGamePlayerSummSpell tooltipped"></img>
                 </div>
                </div>
                <div class="col s4 LiveGamePlayerName">
                  <span class="LiveGamePlayerSummonerName"><?php print $LiveGameParticipant8_SummonerName ?></span>
                </div>
                <div class="col s4 LiveGamePlayerChampion">
                  <img src="<?php print $LiveGameParticipant8_ChampionIcon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant8_ChampionName ?>" class="LiveGamePlayerChampionImage tooltipped"></img>
                </div>
              </div>
            </div>

            <div class = "LiveGamePlayerRow" id="redPlayerRow">
              <div class="row">
                <div class="col s3">
                  <div class="LiveGamePlayerSummonerSpellsRow" id="redSummonerRow">
                    <img src="<?php print $LiveGameParticipant9_Spell1Icon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant9_Spell1Name ?>" class="LiveGamePlayerSummSpell tooltipped"></img>
                    <img src="<?php print $LiveGameParticipant9_Spell2Icon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant9_Spell2Name ?>" class="LiveGamePlayerSummSpell tooltipped"></img>
                 </div>
                </div>
                <div class="col s4 LiveGamePlayerName">
                  <span class="LiveGamePlayerSummonerName"><?php print $LiveGameParticipant9_SummonerName ?></span>
                </div>
                <div class="col s4 LiveGamePlayerChampion">
                  <img src="<?php print $LiveGameParticipant9_ChampionIcon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant9_ChampionName ?>" class="LiveGamePlayerChampionImage tooltipped"></img>
                </div>
              </div>
            </div>

            <div class = "LiveGamePlayerRow" id="redPlayerRow">
              <div class="row">
                <div class="col s3">
                  <div class="LiveGamePlayerSummonerSpellsRow" id="redSummonerRow">
                    <img src="<?php print $LiveGameParticipant10_Spell1Icon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant10_Spell1Name ?>" class="LiveGamePlayerSummSpell tooltipped"></img>
                    <img src="<?php print $LiveGameParticipant10_Spell2Icon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant10_Spell2Name ?>" class="LiveGamePlayerSummSpell tooltipped"></img>
                 </div>
                </div>
                <div class="col s4 LiveGamePlayerName">
                  <span class="LiveGamePlayerSummonerName"><?php print $LiveGameParticipant10_SummonerName ?></span>
                </div>
                <div class="col s4 LiveGamePlayerChampion">
                  <img src="<?php print $LiveGameParticipant10_ChampionIcon ?>" data-position="right" data-delay="25" data-tooltip="<?php print $LiveGameParticipant10_ChampionName ?>" class="LiveGamePlayerChampionImage tooltipped"></img>
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>

<script>

$("body").css("overflow", "hidden");

$(document).ready(function() {

  $('.tooltipped').tooltip({delay: 50});

  $("body").css("overflow", "auto");

  // Fade the document in when its ready loading.
  $(document.body).fadeIn(1200);

  // Send the php variable of the live game duration to javascript.
  var currentLiveGameTimeDuration = <?php echo(json_encode($LiveGameDuration)); ?>;

  // Make infinite loop to update text locally so we dont take riot's bandwidth.
  var timeout = 1000;
  var updateLiveGameDuration = function() {
    if(currentLiveGameTimeDuration == '' || currentLiveGameTimeDuration == null) { return; }
    var minutes = Math.floor(((((currentLiveGameTimeDuration % 31536000) % 86400) % 3600) / 60) + 3);
    var seconds = (((currentLiveGameTimeDuration % 31536000) % 86400) % 3600) % 60;
    if(seconds < 0) { seconds = 0; }
    document.getElementById("gameDurationText").innerHTML = minutes + ':' + seconds;
    currentLiveGameTimeDuration++;
  }
  setInterval(updateLiveGameDuration, timeout);

  // Check if the user has a region set, if not, set it to EUW
  if(localStorage.getItem("currRegion") == null) {
    localStorage.setItem("currRegion", "EUW");
  }
  var currRegion = localStorage.getItem("currRegion");

  // Write the region by the search bar on top of the website
  document.getElementById('search').placeholder= "SEARCH " + currRegion;

});

}

// Refresh the website and find the summoner if a new one was inputted through the search on top
function refreshByInput(){

  $("body").css("overflow", "hidden");
  $('html,body').animate({
      scrollTop: $("body").offset().top},
      'fast');

  var y = $(".search").val();
  y = y.replace(/\s/g, '');

    $.ajax({
      type: 'POST',
      url: 'php/refreshSummoner.php',
      data: {
        summNameInput: y,
      },
      success: function(response) {
        $(".xdtest").text(response);
        window.location.replace('Summoner.php');
      }
    });

}

// Refresh the summoner by input if you press enter
$(document).keypress(function (e) {
    if (e.which == 13 || event.keyCode == 13) {
        refreshByInput();
    }
});

</script>

</div>
</body>

<?php

function getDivisionPicture($tier, $division) {
  if ($tier == "BRONZE") {
    if ($division == "I") {
      return 'img/tier_icons/bronze_i.png';
    } else if ($division == "II") {
      return 'img/tier_icons/bronze_ii.png';
    } else if ($division == "III") {
      return 'img/tier_icons/bronze_iii.png';
    } else if ($division == "IV") {
      return 'img/tier_icons/bronze_iv.png';
    } else if ($division == "V") {
      return 'img/tier_icons/bronze_v.png';
    } else {
      return 'img/base_icons/provisional.png';
    }
  } else if ($tier == "SILVER") {
    if ($division == "I") {
      return 'img/tier_icons/silver_i.png';
    } else if ($division == "II") {
      return 'img/tier_icons/silver_ii.png';
    } else if ($division == "III") {
      return 'img/tier_icons/silver_iii.png';
    } else if ($division == "IV") {
      return 'img/tier_icons/silver_iv.png';
    } else if ($division == "V") {
      return 'img/tier_icons/silver_v.png';
    } else {
      return 'img/base_icons/provisional.png';
    }
  } else if ($tier == "GOLD") {
    if ($division == "I") {
      return 'img/tier_icons/gold_i.png';
    } else if ($division == "II") {
      return 'img/tier_icons/gold_ii.png';
    } else if ($division == "III") {
      return 'img/tier_icons/gold_iii.png';
    } else if ($division == "IV") {
      return 'img/tier_icons/gold_iv.png';
    } else if ($division == "V") {
      return 'img/tier_icons/gold_v.png';
    } else {
      return 'img/base_icons/provisional.png';
    }
  } else if ($tier == "PLATINUM") {
    if ($division == "I") {
      return 'img/tier_icons/platinum_i.png';
    } else if ($division == "II") {
      return 'img/tier_icons/platinum_ii.png';
    } else if ($division == "III") {
      return 'img/tier_icons/platinum_iii.png';
    } else if ($division == "IV") {
      return 'img/tier_icons/platinum_iv.png';
    } else if ($division == "V") {
      return 'img/tier_icons/platinum_v.png';
    } else {
      return 'img/base_icons/provisional.png';
    }
  } else if ($tier == "DIAMOND") {
    if ($division == "I") {
      return 'img/tier_icons/diamond_i.png';
    } else if ($division == "II") {
      return 'img/tier_icons/diamond_ii.png';
    } else if ($division == "III") {
      return 'img/tier_icons/diamond_iii.png';
    } else if ($division == "IV") {
      return 'img/tier_icons/diamond_iv.png';
    } else if ($division == "V") {
      return 'img/tier_icons/diamond_v.png';
    } else {
      return 'img/base_icons/provisional.png';
    }
  } else if ($tier == "MASTER") {
    return 'img/base_icons/master.png';
  } else if ($tier == "CHALLENGER") {
    return 'img/base_icons/challenger.png';
  } else {
    return 'img/base_icons/provisional.png';
  }
}

// Returns you the spell name of the inputted spell ID
function getSpellName($ID) {

  //$SummonerSpellJSON = file_get_contents('https://global.api.riotgames.com/api/lol/static-data/EUW/v1.2/summoner-spell/' . $ID . '?api_key=' . $_SESSION['APIKey']);
  $SummonerSpellData = $_SESSION['SummonerSpellData'];
  foreach ($SummonerSpellData["data"] as $SummonerSpell) {
    if($SummonerSpell["id"] == $ID) {
      return $SummonerSpell["name"];
    }
  }
  return $SummonerSpell->name;

}

// Returns the spell icon of the inputted spell ID
function getSpellIcon($ID) {

  $SummonerSpells = $_SESSION['SummonerSpells'];
  foreach ($SummonerSpells["data"] as $SummonerSpell) {
    if($SummonerSpell["key"] == $ID) {
      return 'http://ddragon.leagueoflegends.com/cdn/6.24.1/img/spell/' . $SummonerSpell["image"]["full"];
    }
  }

}

// Returns the color of the team ID you inputted
function getTeamColor($ID) {
  switch($ID) {
    case 100:
      return 'BLUE';
    case 200:
      return 'RED';
  }
}

// Returns the champion background picture for the champion ID inputted
function getChampionBackgroundPicture($ID) {

  switch($ID) {
    case 1:
      return 'http://lolwp.com/wp-content/uploads/Annie-Classic.jpg';
    case 2:
      return 'https://s-media-cache-ak0.pinimg.com/originals/a2/99/c9/a299c98ee5ff60ad9d487d658905e9d0.jpg';
    case 3:
      return 'http://hdw7.com/wallpapers/278/league-of-legends-game-lol-galio-monster-city.jpg';
    case 4:
      return 'https://images6.alphacoders.com/311/311260.jpg';
    case 5:
      return 'http://www.leaguesplash.com/wp-content/uploads/2013/09/Xin-Zhao-Classic-Ch.jpg';
    case 6:
      return 'http://lolwp.com/wp-content/uploads/2014/06/Urgot-Classic.jpg';
    case 7:
      return 'http://lolwp.com/wp-content/uploads/LeBlanc-Classic1.jpg';
    case 8:
      return 'https://images6.alphacoders.com/344/344715.jpg';
    case 9:
      return 'http://lolwp.com/wp-content/uploads/Fiddlesticks_Splash_10.jpg';
    case 10:
      return 'http://vignette3.wikia.nocookie.net/leagueoflegends/images/7/7f/Kayle_OriginalSkin.jpg/revision/latest?cb=20160519195054';
    case 11:
      return 'http://images5.alphacoders.com/384/384048.jpg';
    case 12:
      return 'http://www.imgbase.info/images/safe-wallpapers/video_games/league_of_legends/53237-alistar_wallpaper.jpg';
    case 13:
      return 'http://ddragon.leagueoflegends.com/cdn/img/champion/splash/Ryze_0.jpg';
    case 14:
      return 'http://lolwp.com/wp-content/uploads/2014/09/Sion-Undead-Juggernaut.jpg';
    case 15:
      return 'http://orig06.deviantart.net/4413/f/2014/316/3/e/league_of_legends_sivir_wallpaper_by_eggmond-d868sdl.png';
    case 16:
      return 'http://orig13.deviantart.net/59f0/f/2014/305/f/a/wallpaper_hd___soraka___league_of_legends_by_aynoe-d84xfai.png';
    case 17:
      return 'https://images4.alphacoders.com/600/600528.png';
    case 18:
      return 'http://anoncraft.com/wp-content/themes/blackwall/custom/dl-save.png';
    case 19:
      return 'https://lolstatic-a.akamaihd.net/frontpage/apps/prod/rg-warwick-update-2017/en_US/411e2fd1e1a0eed5a4d23dd7f9c1b4c0065a10d0/assets/img/ww_base_logo.jpg';
    case 20:
      return 'http://3.bp.blogspot.com/-yHgtl7x197U/U5abUDk7etI/AAAAAAAALCI/0274QiAv9_4/s0/nunu-workshop-skin-christmas-hd-1920x1080.jpg';
    case 21:
      return 'http://www.pixelstalk.net/wp-content/uploads/2016/01/Miss-Fortune-League-of-Legends-Desktop-Backgrounds.jpg';
    case 22:
      return 'https://s-media-cache-ak0.pinimg.com/originals/ad/ff/57/adff57a605813897f5fd0c1292d77bfd.jpg';
    case 23:
      return 'http://www.wickedsa.com/i/2017/03/league-of-legends-tryndamere-wallpaper-hd-resolution.jpg';
    case 24:
      return 'http://wallpapercave.com/wp/UFyxGUN.jpg';
    case 25:
      return 'https://www.walldevil.com/wallpapers/w03/964346-graves-lol-league-of-legends-malphite-lol-morgana-lol.jpg';
    case 26:
      return 'http://4.bp.blogspot.com/-CBVcpnBD0bE/U60nb7qmNmI/AAAAAAAAL60/7tiYdR7-r-8/s0/zilean-league-of-legends-art-1920x1080.jpg';
    case 27:
      return 'http://lolwp.com/wp-content/uploads/Singed-wallpaper.jpg';
    case 28:
      return 'https://www.walldevil.com/wallpapers/a74/league-of-legends-evelynn-lol.jpg';
    //case 29:
      // TWITCH
    case 30:
      return 'http://wallup.net/wp-content/uploads/2016/01/75636-League_of_Legends-Karthus.jpg';
    case 31:
      return 'http://wallup.net/wp-content/uploads/2016/01/91886-League_of_Legends-ChoGath.jpg';
    case 32:
      return 'https://images3.alphacoders.com/658/658032.jpg';
    case 33:
      return 'http://3.bp.blogspot.com/-CZ7fK0a3uJk/UyPVuUSipxI/AAAAAAAAJl0/vcTK7IbkRyo/s1600/Rammus-League-of-Legends-Wallpaper-full-HD-2.png';
    case 34:
      return 'http://static.hdw.eweb4.com/media/wallpapers_2560x1600/games/1/5/anivia-league-of-legends-game-hd-wallpaper-2560x1600-46419.jpg';
    case 35:
      return 'http://orig08.deviantart.net/a3b3/f/2014/324/1/6/shaco___league_of_legends___wallpaper_by_aynoe-d873gnp.png';
    case 36:
      return 'http://wallpapersqq.net/wp-content/uploads/2016/01/Dr.-Mundo-League-of-Legends-5.jpg';
    case 37:
      return 'http://lolwp.com/wp-content/uploads/2012/02/DJ-Sona-Wallpaper-Concussive.jpg';
    case 38:
      return 'http://wallup.net/wp-content/uploads/2016/01/192667-League_of_Legends-Kassadin.jpg';
    case 39:
      return 'https://images5.alphacoders.com/475/thumb-1920-475905.jpg';
    case 40:
      return 'http://orig08.deviantart.net/1ede/f/2016/265/f/9/star_guardian_janna_wallpaper_by_rafasperry-daiiprf.jpg';
    case 41:
      return 'https://static.lolwallpapers.net/2016/02/Gangplank-Fan-Art-By-Victor-Maury.jpg';
    case 42:
      return 'http://www.leaguesplash.com/wp-content/uploads/2013/09/Dragonwing-Corki.jpg';
    case 43:
      return 'http://orig09.deviantart.net/e208/f/2014/361/6/5/karma___league_of_legends___wallpaper_by_aynoe-d8bh2o1.png';
    case 44:
      return 'https://dl.lolwallpapers.net/?id=11025';
    case 45:
      return 'http://www.walldevil.com/wallpapers/a77/veigar-league-of-legends-lol.jpg';
    case 48:
      return 'http://www.desktopimages.org/pictures/2015/1204/1/orig_403233.jpg';
    case 50:
      return 'https://www.walldevil.com/wallpapers/a80/swain-league-of-legends-lol.jpg';
    case 51:
      return 'http://www.mrwallpaper.com/wallpapers/caitlyn-league-of-legends.jpg';
    case 53:
      return 'http://b.rarewallpapers.com/media/wallpapers_1920x1080/3/flying-blitzcrank-league-of-legends-21431.jpg';
    case 54:
      return 'http://lolwp.com/wp-content/uploads/2014/07/Mecha-Malphite-Wallpaper.jpg';
    case 55:
      return 'https://images4.alphacoders.com/567/567359.jpg';
    case 56:
      return 'http://i.imgur.com/wU1Hmhz.jpg';
    case 57:
      return 'https://static.lolwallpapers.net/2014/12/haunted-maikai-fan-art.jpg';
    case 58:
      return 'http://wallup.net/wp-content/uploads/2016/01/194695-League_of_Legends-Renekton.jpg';
    case 59:
      return 'https://images8.alphacoders.com/367/thumb-1920-367786.jpg';
    case 61:
      return 'http://files.padlib.com/soft/f4c90bacc8aaf0fc4188c1397a6e6c0f/Orianna-League-of-Legends-1920x1080.jpg';
    case 62:
      return 'http://lolwp.com/wp-content/uploads/2013/05/Wukong-fanart.jpg';
    case 63:
      return 'http://i.imgur.com/dPkE2YI.jpg';
    case 64:
      return 'https://s-media-cache-ak0.pinimg.com/originals/d2/3d/e3/d23de3ea3b91f4d405897717cbf1bb98.jpg';
    case 67:
      return 'https://images4.alphacoders.com/265/thumb-1920-265064.jpg';
    case 68:
      return 'http://lolwp.com/wp-content/uploads/2014/03/Super-Galaxy-Rumble.jpg';
    case 69:
      return 'https://static.lolwallpapers.net/2014/12/siren-cassiopeia-fan-art.png';
    case 72:
      return 'http://vignette1.wikia.nocookie.net/leagueoflegends/images/4/41/Skarner_Poro.jpg/revision/latest?cb=20150214164243';
    case 74:
      return 'http://img3.wikia.nocookie.net/__cb20150214163744/leagueoflegends/images/9/9d/Heimerdinger_Poro.jpg';
    case 75:
      return 'http://orig04.deviantart.net/8f5f/f/2013/328/1/3/nasus_render_by_somebenny-d6vi9a4.png';
    case 76:
      return 'http://lolwp.com/wp-content/uploads/2012/02/Warring-Kingdoms-Nidalee-wallpaper.jpg';
    case 77:
      return 'https://s-media-cache-ak0.pinimg.com/originals/5a/ed/50/5aed5056ca4d79804555dd4652f629f3.jpg';
    case 78:
      return 'http://wallup.net/wp-content/uploads/2016/01/311277-League_of_Legends-Poppy_League_of_Legends.jpg';
    case 79:
      return 'https://s-media-cache-ak0.pinimg.com/originals/42/fb/a9/42fba97060434ce53f7cb76b5c477bbd.jpg';
    case 80:
      return 'http://fc07.deviantart.net/fs71/f/2015/023/4/2/preseason_2015_art_by_su_ke-d8f1bdj.jpg';
    case 81:
      return 'https://www.walldevil.com/wallpapers/w05/ezreal-league-of-legends-video-games.jpg';
    case 82:
      return 'https://images8.alphacoders.com/467/467091.jpg';
    case 83:
      return 'http://wallpaperplay.com/wallpaper-image/4525_WallpaperPlay_yorickkk-85987_1920x1080.jpg';
    case 84:
      return 'http://konachan.com/image/2ff6f56f91bd1134d41334539f71cecb/Konachan.com%20-%20153816%20akali%20black_hair%20brown_eyes%20league_of_legends%20mask%20ponytail%20weapon%20white.png';
    case 85:
      return 'https://cdn.allwallpaper.in/wallpapers/1920x1080/14807/league-of-legends-kennen-1920x1080-wallpaper.jpg';
    case 86:
      return 'https://s-media-cache-ak0.pinimg.com/originals/c4/26/9c/c4269ced922bb324ff3afd6bd9f61ca6.jpg';
    case 89:
      return 'http://lolwp.com/wp-content/uploads/Leona-wallpaper-by-Sovietpancake.jpg';
    case 90:
      return 'http://sdeerwallpaper.com/Cool-Wallpapers/league-of-legends-malzahar-images-Is-Cool-Wallpapers.jpg';
    case 91: // TALON
      return 'https://i.ytimg.com/vi/EXMBZIyUoZo/maxresdefault.jpg';
    case 92:
      return /*'https://images2.alphacoders.com/588/thumb-1920-588916.png'*/'http://3.bp.blogspot.com/-HlNzr-Oi3ZQ/UxVWy9nWzOI/AAAAAAAAFes/NRKMk1AUnIY/s0/battle-bunny-riven-vs-teemo-hd-1920x1080.jpg';
    //case 96:
      //return ''; KOG MAW
    case 98:
      return 'http://lolwp.com/wp-content/uploads/1330032820_shen_league_of_legends_w1.jpeg';
    case 99:
      return 'https://images4.alphacoders.com/663/663783.jpg';
    case 101:
      return 'http://lolwp.com/wp-content/uploads/Xerath-fanart.jpg';
    case 102:
      return 'http://orig07.deviantart.net/3d6f/f/2015/098/d/9/championship_shyvana_wallpaper___league_of_legends_by_drilo1-d8oz7o5.jpg';
    case 103:
      return 'https://images7.alphacoders.com/517/thumb-1920-517920.jpg';
    case 104:
      return 'https://images4.alphacoders.com/663/663775.jpg';
    case 105:
      return 'http://www.walldevil.com/wallpapers/a76/fizz-league-of-legends-lol.jpg';
    case 106:
      return 'https://cdn.suwalls.com/wallpapers/games/volibear-league-of-legends-28594-2880x1800.jpg';
    case 107:
      return 'http://na.leagueoflegends.com/sites/default/files/upload/art/bg_champion_rengar_1920x1080.jpg';
    case 110:
      return 'https://i.ytimg.com/vi/CMl1-HnSz7c/maxresdefault.jpg';
    case 111:
      return 'https://cdna.artstation.com/p/assets/images/images/000/176/398/large/jesse-sandifer-nautilus-3.jpg?1443929634';
    case 112:
      return 'http://www.desktopimages.org/pictures/2016/0127/1/orig_401804.jpg';
    case 113:
      return 'http://wallup.net/wp-content/uploads/2016/01/266709-League_of_Legends-Poro-sejuani.jpg';
    case 114:
      return 'http://lolwp.com/wp-content/uploads/2012/02/Project-Fiora-1920x1200.jpg';
    case 115:
      return 'https://i.ytimg.com/vi/1H1DmjOCzgU/maxresdefault.jpg';
    case 117:
      return 'http://ddragon.leagueoflegends.com/cdn/img/champion/splash/Lulu_3.jpg';
    case 157:
      return 'https://images.alphacoders.com/658/658090.jpg';
    case 238:
      return 'https://images2.alphacoders.com/524/thumb-1920-524240.jpg';
    default:
      return 'https://s-media-cache-ak0.pinimg.com/originals/9b/6f/a8/9b6fa81e7c4e86b5e9e510c33f90186f.jpg';
  }
}

// Returns the game mode name of the inputted gamemode ID
function getGameModeName($ID, $LiveGameMapID) {
  if($ID == "CLASSIC") {
    if($LiveGameMapID == 1 || $LiveGameMapID == 2 || $LiveGameMapID == 11) {
      return "NORMAL 5v5";
    } else {
      return "NORMAL 3v3";
    }
  } else if($ID == "ODIN") {
    return "DOMINION / CRYSTAL SCAR";
  } else if($ID == "ARAM") {
    return "ARAM";
  } else if($ID == "TUTORIAL") {
    return "TUTORIAL";
  } else if($ID == "ONEFORALL") {
    return "ONE FOR ALL";
  } else if($ID == "ASCENSION") {
    return "ASCENSION";
  } else if($ID == "FIRSTBLOOD") {
    return "SNOWDOWN SHOWDOWN";
  } else if($ID == "KINGPORO") {
    return "KING PORO";
  } else if($ID == "SIEGE") {
    return "NEXUS SIEGE";
  } else {
    return "UNKNOWN GAMEMODE";
  }
}

// Returns the map name of the map ID inputted
function getMapName($ID) {

  $MapInformationDATA = $_SESSION['MapInformationDATA'];
  foreach ($MapInformationDATA as $IDs) {
    if($IDs["mapId"] == $ID) {
      $mapName = $IDs["mapName"];
      break;
    }
  }

  return $mapName;
}

// Returns the champion name of the champion ID inputted
function getChampionName($ID) {
  //$championInformationJSON = file_get_contents('https://global.api.riotgames.com/api/lol/static-data/EUW/v1.2/champion/' . $ID . '?api_key=' . $_SESSION["APIKey"]);
  $championInformation = $_SESSION["championInformation"];
  foreach ($championInformation["data"] as $champion) {
    if($champion["id"] == $ID) {
      return $champion["name"];
    }
  }
  return $championInformation->name;
}

function getQueueConfigIdName($ID) {
  switch($ID) {
    case "2":
      return "NORMAL BLIND 5v5";
    case "8":
      return "NORMAL 3v3";
    case "9":
      return "RANKED FLEX 5v5";
    case "16":
      return "DOMINION BLIND 5v5";
    case "17":
      return "DOMINION DRAFT 5v5";
    case "25":
      return "DOMINION COOP vs AI";
    case "31":
      return "COOP vs AI - INTRO";
    case "32":
      return "COOP VS AI - BEGINNER";
    case "33":
      return "COOP VS AI - INTERMEDIATE";
    case "52":
      return "COOP VS AI";
    case "65":
      return "ARAM";
    case "70":
      return "ONE FOR ALL";
    case "76":
      return "URF";
    case "96":
      return "ASCENSION";
    case "98":
      return "HEXAKILL";
    case "300":
      return "KING PORO";
    case "310":
      return "COUNTER PICK";
    case "315":
      return "SIEGE";
    case "317":
      return "DEFINITELY NOT DOMINION";
    case "318":
      return "ALL RANDOM URF";
    case "400":
      return "NORMAL DRAFT 5v5";
    case "410":
      return "RANKED DRAFT 5v5";
    case "420":
      return "RANKED SOLO/DUO";
    case "440":
      return "RANKED FLEX 5v5";
    case "600":
      return "BLOOD MOON";
    default:
      return $ID;
  }
}

function getELO($ID, &$selfTier, &$selfDivision) {
  $url = 'https://euw.api.pvp.net/api/lol/euw/v2.5/league/by-summoner/' . $ID . '?api_key=' . $_SESSION["APIKey"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
  $eloJSON = curl_exec($ch);
  curl_close($ch);
  $elo = json_decode($eloJSON, true);
  $first_league = $elo[$ID][0];
  $tier = $first_league["tier"];
  //print $tier;
  $selfTier = $tier;
  $entries = $first_league["entries"];
  for ($i=0; $i < count($entries); $i++) {
    if($entries[$i]["playerOrTeamId"] == $ID) {
      $division = $entries[$i]["division"];
      //print $division;
      $selfDivision = $division;
      break;
    }
  }

  if($selfTier == null) { $selfTier = null; }
  if($selfDivision == null) { $selfDivision = null; }

  //print $ID . ' IS CURRENTLY ' . $selfTier . ' ' . $selfDivision . '<br/>';

}

// Returns the champion icon of the champion ID inputted
function getChampionIcon($NAME) {
  $NAME = preg_replace('/\s+/', '', $NAME);
  if(strtolower($NAME) == 'wukong') { $NAME = 'MonkeyKing'; }
  if(strtolower($NAME) == 'fiddlesticks') { $NAME = 'FiddleSticks'; }
  if(strtolower($NAME) == "kog'maw") { $NAME = 'KogMaw'; }
  if(strtolower($NAME) == "cho'gath") { $NAME = 'Chogath'; }
  if(strtolower($NAME) == "vel'koz") { $NAME = 'Velkoz'; }
  if(strtolower($NAME) == "kha'zix") { $NAME = 'Khazix'; }
  if(strtolower($NAME) == "aurelionsol") { $NAME = 'AurelionSol'; }
  if(strtolower($NAME) == "tahmkench") { $NAME = 'TahmKench'; }
  if(strtolower($NAME) == "rek'sai") { $NAME = 'RekSai'; }
  if(strtolower($NAME) == "jarvaniv") { $NAME = 'JarvanIV'; }
  if(strtolower($NAME) == "xinzhao") { $NAME = 'XinZhao'; }
  if(strtolower($NAME) == "twistedfate") { $NAME = 'TwistedFate'; }
  if(strtolower($NAME) == "missfortune") { $NAME = 'MissFortune'; }
  if(strtolower($NAME) == "dr.mundo") { $NAME = 'DrMundo'; }
  if(strtolower($NAME) == "leblanc") { $NAME = 'Leblanc'; }
  return 'http://ddragon.leagueoflegends.com/cdn/6.24.1/img/champion/' . $NAME . '.png';
}

 ?>
