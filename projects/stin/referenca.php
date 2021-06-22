<?php
require_once("php/DBConnect.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$sql = "SELECT ID, naslov, vsebina, datumdodajanja FROM reference WHERE ID=:id";
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $_GET['id']);
$result = $stmt->execute();
$referenca = $stmt->fetch();

$sql = "SELECT ID, slika FROM referenca_slike WHERE referenca_ID=:refID";
$stmt = $db->prepare($sql);
$stmt->bindValue(':refID', $referenca['ID']);
$result = $stmt->execute();
$slike = $stmt->fetchAll();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" dir="ltr">
  <head>
    <title>Stin.si :: Referenca <?php echo $referenca['naslov']; ?></title>
    <link rel="icon"
        type="image/png"
        href="uploads/logo-only.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="title" content="Stin.si referenca">
    <meta name="description" content="Stin.si :: strojne inštalacije, ogrevanje, vodovod, ESCO, hlajenje, prezracevanje, klimatizacija, krovska dela, krovske storitve">
    <meta name="keywords" content="stin, stin.si, strojne inštalacije, ogrevanje, vodovod, ESCO, hlajenje, prezracevanje, klimatizacija, krovska dela, krovske storitve">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="language" content="English">
    <meta name="author" content="Marko Plaznik">

    <link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet">
    <link rel="stylesheet prefetch" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
    <link rel="stylesheet" href="css/unite-gallery.css">
    <link rel="stylesheet" href="css/ug-theme-default.css">
    <link rel="stylesheet" href="css/global.css?v=1.0">
    <link rel="stylesheet" href="css/nav-white-bg.css">
    <link rel="stylesheet" href="css/icon.min.css">
    <link rel="stylesheet" href="css/referenca.css">
    <style media="screen">
      #navbar .right.menu .item a {
        color: black;
        text-shadow: none;
      }
    </style>
  </head>
  <body class="pushable">

    <!-- Sidebar Menu -->
    <div class="ui vertical right sidebar menu">
      <div class="item clickable" onclick="window.location.href = 'index.php'">
        <img class="ui mini image" src="res/logo-2_optimized-248x100.png?v=1.1" style="height: 80px">
      </div>
      <a href="opodjetju.html" id="mobile-about-cpmn" class="item">O podjetju</a>
      <a href="ESCO.html" class="item">ESCO</a>
      <a href="vse.php?type=novice" class="item">Novice</a>
      <a href="vse.php?type=reference" class="item">Reference</a>
      <a href="kontakt.php" id="mobile-cntc" class="item">Kontakt</a>
    </div>

    <div class="pusher">

      <div class="ui grid">

        <div class="computer only row">
          <div class="column">
            <div id="navbar" class="ui massive fixed borderless secondary menu">
              <div class="nav-background"></div>
              <div class="item clickable" onclick="window.location.href = 'index.php'">
                <img id="nav-logo" src="res/logo-2-white-shadow_optimized-248x100.png?v=1.0" style="height: 70px; width: auto; transition-duration: 0.3s">
              </div>
              <div class="right menu">
                <div class="item">
                  <a id="about-company-nav" href="opodjetju.html">O podjetju</a>
                </div>
                <div class="item">
                  <a href="ESCO.html">ESCO</a>
                </div>
                <div class="item">
                  <a href="vse.php?type=novice">Novice</a>
                </div>
                <div class="item">
                  <a href="vse.php?type=reference">Reference</a>
                </div>
                <div class="item">
                  <a href="kontakt.php">Kontakt</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="tablet mobile only row">
          <div class="column">
            <div id="mobile-navbar" class="ui fixed borderless massive secondary menu">
              <div class="nav-background nav-bg-mobile"></div>
              <a id="mobile-nav-logo" class="item"> <img src="res/logo-2-white-shadow_optimized-248x100.png" style="height: 50px" alt=""> </a>
              <a id="mobile_item" class="right item"> <i class="bars icon" style="font-size: 1.9em !important; color: black !important; text-shadow: none !important;"></i> </a>
            </div>
          </div>
        </div>

      </div>

      <div class="ui container" style="min-height: 100vh; display: flex; justify-content: center; align-items: center; flex-direction: column; padding: 20px 0px">

          <div id="content-wrapper">

            <h1> <?php echo $referenca['naslov']; ?> </h1>
            <p> <?php echo $referenca['datumdodajanja']; ?> </p>

            <p> <?php echo nl2br($referenca['vsebina']);  ?> </p>

            <?php if ($stmt->rowCount() > 0) { ?>

            <div style="width: 100%" class="ui basic segment">
              <div id="gallery" style="display: none; margin: 0 auto;">

                <?php

                foreach ($slike as $key => $value) {
                  echo '<img class="ui small centered image" data-image="uploads/reference/'.$value['slika'].'" src="uploads/reference/'.$value['slika'].'"/>';
                }

                ?>
              </div>
            </div>

            <?php } ?>

            <button style="margin-top: 0px" onclick="window.location.href = 'vse.php?type=reference'" class="ui orange basic button">Nazaj</button>

          </div>

      <footer>
        <div class="ui container">

          <div class="ui stackable two column grid" style="height: 100%">
            <div class="column" style="display: flex; justify-content: center; align-items: center; flex-direction: column">
              <img src="res/logo-2_optimized-248x100.png?v=1.1" style="width: auto; height: 60px">
              <br>
              <p style="font-size: 12px">© 2008-2016 Stin, d.o.o. Vse pravice pridržane</p>
            </div>
            <div class="column" style="display: flex; flex-direction: column; justify-content: center; align-items: center">
              <p> <span style="font-weight: bold">Telefon </span> +386-2-7070-750</p>
              <p> <span style="font-weight: bold">E-Pošta </span> <a style="color: #ba0404" href="mailto:info@stin.si"> info@stin.si </a> </p>
            </div>
          </div>

        </div>
      </footer>

    </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
    <script src="js/unitegallery.min.js" charset="utf-8"></script>
    <script src="js/ug-theme-slider.js" charset="utf-8"></script>
    <script src="js/referenca_script.min.js" charset="utf-8"></script>
    <script src="js/global.min.js" charset="utf-8"></script>
  </body>
</html>
