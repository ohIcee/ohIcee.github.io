<?php
require_once 'php/DBConnect.php';

$sql = "SELECT ID, naslov, datumdodajanja, podnaslov, slika FROM novice ORDER BY datumdodajanja DESC LIMIT 3";
$stmt = $db->prepare($sql);
$result = $stmt->execute();
$noviceRows = $stmt->fetchAll();

$sql = "SELECT ID, naslov, datumdodajanja, vsebina FROM reference ORDER BY datumdodajanja DESC LIMIT 4";
$stmt = $db->prepare($sql);
$result = $stmt->execute();
$referenceRows = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <title>Stin.si :: strojne inštalacije :: ogrevanje :: klimatizacija :: prezračevanje :: vodovod :: plinovod :: toplovod</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <link rel="shortcut icon" type="image/png" href="./res/logo-only_optimized.png?v=1.0"/>

  <meta name="title" content="Stin.si domov">
  <meta name="description" content="Stin.si :: strojne inštalacije, ogrevanje, vodovod, ESCO, hlajenje, prezracevanje, klimatizacija, krovska dela, krovske storitve">
  <meta name="keywords" content="stin, stin.si, strojne inštalacije, ogrevanje, vodovod, ESCO, hlajenje, prezracevanje, klimatizacija, krovska dela, krovske storitve">
  <meta name="robots" content="index, follow">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="language" content="English">
  <meta name="author" content="Marko Plaznik">

  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css?v=1.12.1">
  <link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet">
  <link rel="stylesheet prefetch" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css?v=2.4.2.min">
  <link rel="stylesheet" href="css/unite-gallery.css?v=1.0">
  <link rel="stylesheet" href="css/ug-theme-default.css?v=1.0">
  <link rel="stylesheet" href="css/global.css?v=1.1">
  <link rel="stylesheet" href="css/index_design.css?v=1.3">
  <link rel="stylesheet" href="css/icon.min.css?v=1.0">
  <link rel="stylesheet" href="css/jumbotron.min.css?v=1.0">
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
            <a id="mobile_item" class="right item"> <i class="bars icon" style="font-size: 1.9em !important"></i> </a>
          </div>
        </div>
      </div>

    </div>

    <div class="jumbotron jumbotron-fluid">
      <div class="ui container carousel-container">
        <h1 id="carousel-header" class="display-4"></h1>
        <p id="carousel-paragraph" class="lead"></p>
      </div>
      <div class="slider-dot-control">
        <label id="0" onclick="onSliderDot(0)"></label>
        <label id="1" onclick="onSliderDot(1)"></label>
        <label id="2" onclick="onSliderDot(2)"></label>
      </div>
    </div>

    <div class="ui container">

      <div style="display: flex; justify-content: center; min-height: 100%; width: 100%">
        <div>

          <div>
            <div id="content-wrapper">

              <div class="ui stackable two column grid">
                <div class="column">
                  <a class="anchor" id="opodjetju-anchor"></a>
                  <section class="section" id="opodjetju">
                    <h1 class="section-header">O podjetju</h1>
                    <p><strong>STIN d.o.o.</strong> je eno od vodilnih podjetij na področju izvajanja strojnih
                      inštalacij in izvedbe energetskih storitev na področju Slovenije.</p>

                    <button style="margin-top: 0px" id="more-company-info-button" class="ui orange basic button">Več informacij</button>

                    <div id="more-about">
                      <p>Od ustanovitve, leta 2006, smo zabeležili visoko rast, izvedli mnogo
                        projektov in pomagali številnim podjetjem ter javnim institucijam pri
                        energetski učinkovitosti in izvedbi strojnih inštalacij. Tudi v
                        prihodnje bomo povečevali raznolikost in širino naših storitev, da
                        bomo svojim naročnikom lahko dosledno ponujali najučinkovitejše
                        energetske rešitve in izvedbe.
                      </p>
                      <h2>Poslanstvo:</h2>
                      <p>Zagotavljati inovativne, tehnološko napredne in zanesljive energetske
                        rešitve ter projekte, ki močno izboljšujejo energetsko učinkovitost,
                        okoljski odtis in poslovno konkurenčnost naših naročnikov.
                      </p>
                      <h2>Tehnološka nevtralnost:</h2>
                      <p>Nismo odvisni od posameznega proizvajalca opreme ali tehnologije, tako
                        da lahko svojim naročnikom vedno zagotavljamo najboljšo razpoložljivo
                        tehnologijo, ki ustreza njihovim potrebam.</p>

                      <h2>Raznoliko znanje in izkušnje:</h2>
                      <p>Našo ekipo sestavljajo uveljavljeni strokovnjaki, ki imajo znanja z
                        različnih strokovnih področij in regionalne izkušnje, zato lahko
                        svojim naročnikom nudimo zelo širok nabor specializiranih energetskih
                        storitev.</p>
                      <p>Znanje in predanost naših zaposlenih, naročnikom zagotavlja kakovostne
                        in zanesljive storitve.</p>

                      <h2>Dejavnosti podjetja:</h2>


                      <div class="ui styled fluid accordion">
                        <div class="title">
                          <i class="dropdown icon"></i>
                          Vodovodne inštalacije
                        </div>
                        <div class="content">
                          <ul>
                            <li>Vodovodne inštalacije v objektih</li>
                            <li>Zunanja vodovodna omrežja</li>
                            <li>Meteorne in fekalne kanalizacije</li>
                            <li>Hidroforne postaje</li>
                            <li>Kanalizacija v objektih</li>
                          </ul>
                        </div>
                        <div class="title">
                          <i class="dropdown icon"></i>
                          Ogrevanje
                        </div>
                        <div class="content">
                          <ul>
                            <li>Toplotne črpalke</li>
                            <li>Kotlovnice, toplotne podpostaje</li>
                            <li>Radiatorsko ogrevanje</li>
                            <li>Konvektorsko ogrevanje</li>
                            <li>Talno ogrevanje</li>
                            <li>Stensko in stropno ogrevanje</li>
                            <li>Daljinsko ogrevanje (vročevod)</li>
                          </ul>
                        </div>
                        <div class="title">
                          <i class="dropdown icon"></i>
                          Hlajenje, klimatizacija in prezračevanje
                        </div>
                        <div class="content">
                          <ul>
                            <li>Predizolirani kanalski razvodi</li>
                            <li>Pločevinasti kanalski razvodi</li>
                            <li>Klimatsko prezračevanje</li>
                            <li>Split sistemi</li>
                            <li>Konvektorsko hlajenje</li>
                            <li>Hladilne postaje</li>
                          </ul>
                        </div>
                        <div class="title">
                          <i class="dropdown icon"></i>
                          Plinske inštalacije
                        </div>
                        <div class="content">
                          <ul>
                            <li>Plinske kotlovnice</li>
                            <li>Notranje plinske inštalacije</li>
                            <li>Zunanje plinske inštalacije</li>
                            <li>Tehnični plini</li>
                          </ul>
                        </div>
                        <div class="title">
                          <i class="dropdown icon"></i>
                          Krovska dela strešin z minimalnim naklonom
                        </div>
                        <div class="content">
                          <ul>
                            <li>Kritje z bitumensko kritino</li>
                            <li>Kritje z gladko pločevino</li>
                          </ul>
                        </div>
                        <div class="title">
                          <i class="dropdown icon"></i>
                          Krovske storitve na poševnih strešinah
                        </div>
                        <div class="content">
                          <ul>
                            <li>Kritje z vlakno-cementno kritino</li>
                            <li>Kritje s profilirano kritino</li>
                            <li>Kritje z opečno kritino</li>
                            <li>Kritje z betonsko kritino</li>
                          </ul>
                        </div>
                      </div>

                      <button style="margin-top: 10px;" id="less-company-info-button" class="ui orange basic button">Manj informacij</button>
                    </div>

                  </section>

                  <a class="anchor" id="novice-anchor"></a>
                  <section class="section" id="novice">
                    <h1 class="section-header"><i class="newspaper outline icon"></i> Novice</h1>
                    <div class="ui items novice">

                      <?php
                          foreach ($noviceRows as $key => $value) {

                            $img = "";
                            if ($value['slika'] != null) {
                              $img = '
                                <a class="ui small image" imgname="'.$value['slika'].'">
                                </a>
                              ';
                            } // <img src="uploads/novice/'.$value['slika'].'?v=1"/>

                            echo '
                              <div class="item novica">
                                '.$img.'
                                <div class="content">
                                  <a class="header">' . $value['naslov'] . '</a>
                                  <div class="description">
                                    <p id="date" style="line-height: 0; font-style: italic">Datum: ' . $value['datumdodajanja'] . '</p>
                                    <p>' . mb_strimwidth(nl2br($value['podnaslov']), 0, 120, " [...]") . '</p>
                                    <a href="vse.php?type=novice&novica='.$value['ID'].'">Prikaži novico</a>
                                  </div>
                                </div>
                              </div>
                            ';
                          }
                          ?>

                      <!-- <a href="vse.php?type=novice">Vse novice</a> -->
                      <button onclick="window.location.href = 'vse.php?type=novice'" class="ui red basic button">Vse novice</button>
                    </div>
                  </section>
                </div>
                <div class="column">
                  <section class="section" id="reference" style="min-height: 70vh">
                    <h1 class="section-header" style="color: #FEA759"><i class="newspaper outline icon"></i> Zadnje Reference</h1>
                    <div class="ui items reference">

                      <?php
                          foreach ($referenceRows as $key => $value) {

                            // GET IMG
                            $sql = "SELECT slika FROM referenca_slike WHERE referenca_ID=:id";
                            $stmt = $db->prepare($sql);
                            $stmt->bindValue(':id', $value['ID']);
                            $result = $stmt->execute();
                            $slika = $stmt->fetch();

                            $img = "";
                            if ($slika['slika'] != null) {
                              $img = '
                                <a class="ui small image" imgname="'.$slika['slika'].'">
                                </a>
                              ';
                            } //<img src="uploads/reference/'. $slika['slika'] .'?v=1"/>

                            echo '
                              <div class="item referenca">
                                '.$img.'
                                <div class="content">
                                  <a class="header">' . $value['naslov'] . '</a>
                                  <div class="description">
                                    <p id="date" style=" line-height: 0; font-style: italic">Datum izvedbe: ' . $value['datumdodajanja'] . '</p>
                                    <p>' . mb_strimwidth(nl2br($value['vsebina']), 0, 120, " [...]") . '</p>
                                    <a href="referenca.php?id='.$value['ID'].'">Pokaži več</a>
                                  </div>
                                </div>
                              </div>
                            ';
                          }
                          ?>

                      <!-- <a href="vse.php?type=reference">Vse reference</a> -->
                      <button onclick="window.location.href = 'vse.php?type=reference'" class="ui orange basic button">Vse reference</button>
                    </div>
                  </section>
                </div>
              </div>

              <section class="section" id="kontakt" style="min-height: 70vh; width: 100%">
                <a class="anchor" id="kontakt-anchor"></a>
                <h1 class="section-header"><i class="phone icon"></i> Kontakt</h1>

                <div class="ui stackable two column grid">
                  <div class="column" style="padding-left: 0 !important; padding-right: 0 !important;">
                    <?php
                    if (preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false)) { } else { ?>
                      <iframe style="width: 100%; height: 100%; min-height: 200px" id="gmap_canvas" src="https://maps.google.com/maps?q=Trg%204.%20julija%2067&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                    <?php } ?>
                  </div>
                  <div class="column">

                    <h3 class="ui horizontal divider header">
                      <i class="map pin icon"></i>
                      Kje se nahajamo?
                    </h3>

                    <p style="font-weight: bold">Naslov</p>
                    <p>STIN, d.o.o.</p>
                    <p>Trg 4. julija 67</p>
                    <p>2370 Dravograd</p>

                    <h3 class="ui horizontal divider header">
                      <i class="phone icon"></i>
                      Kontaktiraj nas!
                    </h3>

                    <p> <span style="font-weight: bold">Telefon </span> +386-2-7070-750</p>
                    <p> <span style="font-weight: bold">E-Pošta </span> <a style="color: #ba0404" href="mailto:info@stin.si"> info@stin.si </a> </p>

                    <div id="company-details">
                      <h3 class="ui horizontal divider header">
                        <i class="address card icon"></i>
                        Osnovni podatki o podjetju
                      </h3>

                      <table class="ui very basic table">
                        <tbody>

                          <tr>
                            <td>
                              <h3 class="ui image header">
                                <div class="content">
                                  Naziv podjetja
                                </div>
                              </h3>
                            </td>
                            <td>Stin, podjetje za strojne inštalacije, d.o.o.</td>
                          </tr>

                          <tr>
                            <td>
                              <h3 class="ui image header">
                                <div class="content">
                                  Krajši naziv podjetja
                                </div>
                              </h3>
                            </td>
                            <td>Stin d.o.o.</td>
                          </tr>

                          <tr>
                            <td>
                              <h3 class="ui image header">
                                <div class="content">
                                  Naslov
                                </div>
                              </h3>
                            </td>
                            <td>Trg 4. julija 67, 2370 Dravograd</td>
                          </tr>

                          <tr>
                            <td>
                              <h3 class="ui image header">
                                <div class="content">
                                  Telefon
                                </div>
                              </h3>
                            </td>
                            <td>+386-2-7070-750</td>
                          </tr>

                          <tr>
                            <td>
                              <h3 class="ui image header">
                                <div class="content">
                                  E-Pošta
                                </div>
                              </h3>
                            </td>
                            <td> <a href="mailto:info@stin.si">info@stin.si</a> </td>
                          </tr>

                          <tr>
                            <td>
                              <h3 class="ui image header">
                                <div class="content">
                                  Spletna stran
                                </div>
                              </h3>
                            </td>
                            <td> <a href="http://www.stin.si">http://www.stin.si</a> </td>
                          </tr>

                          <tr>
                            <td>
                              <h3 class="ui image header">
                                <div class="content">
                                  Matična številka
                                </div>
                              </h3>
                            </td>
                            <td>2303230000</td>
                          </tr>

                          <tr>
                            <td>
                              <h3 class="ui image header">
                                <div class="content">
                                  ID št. za DDV
                                </div>
                              </h3>
                            </td>
                            <td>SI61383945</td>
                          </tr>

                          <tr>
                            <td>
                              <h3 class="ui image header">
                                <div class="content">
                                  Zavezanec za DDV
                                </div>
                              </h3>
                            </td>
                            <td>DA</td>
                          </tr>

                          <tr>
                            <td>
                              <h3 class="ui image header">
                                <div class="content">
                                  Št. TRR
                                </div>
                              </h3>
                            </td>
                            <td>Banka Koper: SI56 1010 0004 3939 831</td>
                          </tr>

                          <tr>
                            <td>
                              <h3 class="ui image header">
                                <div class="content">
                                  Osnovni kapital
                                </div>
                              </h3>
                            </td>
                            <td>EUR 167.500,00</td>
                          </tr>

                          <tr>
                            <td>
                              <h3 class="ui image header">
                                <div class="content">
                                  Leto ustanovitve
                                </div>
                              </h3>
                            </td>
                            <td>2007</td>
                          </tr>

                          <tr>
                            <td>
                              <h3 class="ui image header">
                                <div class="content">
                                  Direktor podjetja
                                </div>
                              </h3>
                            </td>
                            <td>Jure Žvikart</td>
                          </tr>

                        </tbody>
                      </table>
                    </div>

                    <button id="more-contact-info-button" class="ui red basic button">Podrobnosti o podjetju</button>

                  </div>
                </div>

              </section>

            </div>
          </div>


        </div>
      </div>

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

  <script src="https://code.jquery.com/jquery-3.1.1.min.js?v=3.1.1.min" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js?v=1.12.1.min"></script>
  <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js?v=2.4.2"></script>
  <script src="js/unitegallery.min.js?v=1.0" charset="utf-8"></script>
  <script src="js/index_script.min.js?v=1.2" charset="utf-8"></script>
  <script src="js/global.min.js" charset="utf-8"></script>
  <script src="js/stin-carousel.js?v=1.0" charset="utf-8"></script>
</body>

</html>
