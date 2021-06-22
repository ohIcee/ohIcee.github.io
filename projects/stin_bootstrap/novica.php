<?php
require_once("php/DBConnect.php");

$sql = "SELECT naslov, vsebina, datumdodajanja, podnaslov, slika FROM novice WHERE ID=:id";
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $_GET['id']);
$result = $stmt->execute();
$novica = $stmt->fetch();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" dir="ltr">
  <head>
    <title>Stin.si :: Novica <?php echo $novica['naslov']; ?></title>
    <link rel="icon"
        type="image/png"
        href="uploads/logo-only.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="title" content="Stin.si novica">
    <meta name="description" content="Stin.si :: strojne inštalacije :: ogrevanje :: vodovod">
    <meta name="keywords" content="stin, stin.si, strojne instalacije, ogrevanje, vodovod, esco">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="author" content="Marko Plaznik">

    <link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet">
    <link rel="stylesheet prefetch" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
    <link rel="stylesheet" href="css/global.min.css?v=1.0">
    <link rel="stylesheet" href="css/icon.min.css">
    <link rel="stylesheet" href="css/novica.css">
    <style media="screen">
      #navbar .right.menu .item a {
        color: black;
        text-shadow: none;
      }
    </style>
  </head>
  <body class="pushable">

    <!-- Sidebar Menu -->
    <div class="ui vertical sidebar menu">
      <div class="item clickable" onclick="window.location.href = 'index.php'">
        <img class="ui mini image" src="res/logo-2_optimized-248x100.png?v=1.1" style="height: 80px">
      </div>
      <a href="index.php#opodjetju-anchor" id="mobile-about-cpmn" class="active item">O podjetju</a>
      <a href="vse.php?type=novice" class="item">Novice</a>
      <a href="vse.php?type=reference" class="item">Reference</a>
      <a href="index.php#kontakt-anchor" id="mobile-cntc" class="item">Kontakt</a>
      <a href="ESCO.html" class="item">ESCO</a>
    </div>

    <div class="pusher">

      <div class="ui grid">

        <div class="computer only row">
          <div class="column">
            <div id="navbar" class="ui massive fixed borderless secondary menu">
              <div class="nav-background"></div>
              <div class="item clickable" onclick="window.location.href = 'index.php'">
                <img id="nav-logo" src="res/logo-2.png?v=1.0" style="height: 70px; width: auto; transition-duration: 0.3s">
              </div>
              <div class="right menu">
                <div class="item">
                  <a id="about-company-nav" href="index.php#opodjetju-anchor"  >O podjetju</a>
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
                  <a href="index.php#kontakt-anchor">Kontakt</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="tablet mobile only row">
          <div class="column">
            <div id="mobile-navbar" class="ui fixed borderless massive secondary menu">
              <a id="mobile_item" class="item"> <i class="bars icon" style="font-size: 1.9em !important"></i> </a>
            </div>
          </div>
        </div>

      </div>

      <div class="ui container" style="min-height: 100vh; display: flex; justify-content: center; align-items: center; flex-direction: column; padding: 20px 0px">

        <div id="content-wrapper">

          <h1> <?php echo $novica['naslov']; ?> </h1>
          <p> <?php echo $novica['datumdodajanja']; ?> </p>

          <div class="ui basic segment">
            <?php if ($novica['slika'] != null) { echo '<img id="slika" class="ui small left floated image" style="width: 300px" src="uploads/novice/'.$novica['slika'].'"/>'; } ?>
            <p> <?php echo $novica['vsebina']; ?> </p>
          </div>

          <button style="margin-top: 0px" onclick="window.location.href = 'vse.php?type=novice'" class="ui orange basic button">Nazaj</button>

        </div>

        <footer>
          <div class="ui container">

            <div class="ui stackable two column grid" style="height: 100%">
              <div class="column" style="display: flex; justify-content: center; align-items: center; flex-direction: column">
                <img src="res/logo-2.png" style="width: auto; height: 100px">
                <br>
                <p>© 2008-2016 Stin, d.o.o. Vse pravice pridržane</p>
              </div>
              <div class="column" style="display: flex; flex-direction: column; justify-content: center; align-items: center">
                <p> <span style="font-weight: bold">Telefon </span> +386-2-7070-750</p>
                <p> <span style="font-weight: bold">Faks </span> +386-2-8783-251</p>
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
    <script src="js/global.min.js" charset="utf-8"></script>
  </body>
</html>
