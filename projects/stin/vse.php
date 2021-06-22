<?php
require_once("php/DBConnect.php");

$type = $_GET['type'];

$objave = [];
if ($type == "novice") {
  $sql = "SELECT ID, naslov, datumdodajanja, podnaslov, slika, vsebina FROM novice ORDER BY datumdodajanja DESC";
  $stmt = $db->prepare($sql);
  $result = $stmt->execute();
  $objave = $stmt->fetchAll();
} else if ($type == "reference") {
  $sql = "SELECT ID, naslov, datumdodajanja, vsebina FROM reference ORDER BY datumdodajanja DESC";
  $stmt = $db->prepare($sql);
  $result = $stmt->execute();
  $objave = $stmt->fetchAll();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" dir="ltr">
  <head>
    <title>Stin.si :: <?php echo $_GET['type'] ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="./res/logo-only_optimized.png?v=1.0"/>

    <meta name="robots" content="noindex, nofollow"/>
    <meta name="title" content="Stin.si">
    <meta name="description" content="Stin.si :: strojne inštalacije, ogrevanje, vodovod, ESCO, hlajenje, prezracevanje, klimatizacija, krovska dela, krovske storitve">
    <meta name="keywords" content="stin, stin.si, strojne inštalacije, ogrevanje, vodovod, ESCO, hlajenje, prezracevanje, klimatizacija, krovska dela, krovske storitve">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="language" content="English">
    <meta name="author" content="Marko Plaznik">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vivus/0.4.4/vivus.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet">
    <link rel="stylesheet prefetch" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
    <link rel="stylesheet" href="css/global.css?v=1.0">
    <link rel="stylesheet" href="css/icon.min.css">
    <link rel="stylesheet" href="css/vse_design.css?v=1.2">
    <link rel="stylesheet" href="css/nav-white-bg.css">
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

          <h1 class="section-header" style="text-transform: capitalize"> <?php echo $_GET['type']; ?> </h1>

          <div class="ui items stackable link cards">
          <?php
          foreach ($objave as $key => $value) {

            if ($type == "novice") {

              $img = "";
              if ($value['slika'] != null) {
                $img = '
                  <a class="postImg" imgname="'.$value['slika'].'"></a>
                ';
              }

              echo '
                <div class="ui vertical segment '.$value['ID'].'" style="width: 100%; min-height: 200px">
                  <a class="anchor" id="'.$value['ID'].'"></a>
                  <img class="ui left floated image" src="uploads/novice/'.$value['slika'].'">
                  <h3>'.$value['naslov'].'</h3>
                  <p style="color: gray">'.$value['datumdodajanja'].'</p>
                  <p>'.$value['vsebina'].'</p>
                </div>
              ';

            } else if ($type == "reference") {
              // GET IMG
              $sql = "SELECT slika FROM referenca_slike WHERE referenca_ID=:id";
              $stmt = $db->prepare($sql);
              $stmt->bindValue(':id', $value['ID']);
              $result = $stmt->execute();
              $slika = $stmt->fetch();

              $img = "";
              if ($slika['slika'] != null) {
                $img = '
                  <a class="ui image postImg" imgname="'.$slika['slika'].'"></a>
                ';
              }

              $naslov = strlen($value['naslov']) < 35 ? $value['naslov'] . '' . "\n\n" : $value['naslov'];

              echo '
                  <div class="ui card" id="'.$value['ID'].'">
                    <div class="image">
                      '.$img.'
                    </div>
                    <div class="content">
                      <div class="header">'. nl2br($naslov) . ' </div>
                      <div class="meta">
                        <a>'.$value['datumdodajanja'].'</a>
                      </div>
                      <div class="description">
                        '.mb_strimwidth($value['vsebina'], 0, 80, " [...]").'
                      </div>
                      <div class="extra content">
                        <div class="ui two buttons">
                          <a class="ui basic red button" href="referenca.php?id='.$value['ID'].'">Pokaži več</a>
                        </div>
                      </div>
                    </div>
                  </div>';
            }

          }
          ?>
          </div>

          <div style="width: 100%;">
            <button style="margin-top: 20px" onclick="window.location.href = 'index.php'" class="ui orange basic button">Domov</button>
          </div>

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
    <script src="js/global.min.js" charset="utf-8"></script>
    <script src="js/vse_script.min.js?v=1.3" charset="utf-8"></script>
  </body>
</html>
