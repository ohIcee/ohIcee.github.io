<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function clean_string($string) {
  $bad = array("content-type","bcc:","to:","cc:","href");
  return str_replace($bad,"",$string);
}

echo "ree";

if (isset($_POST["emailform"])) {
  echo "YEET";

  $email_to = "info@stin.si";

  $name = $_POST['name'];
  $company = $_POST['podjetje'];
  $email_from = $_POST['email'];
  $telephone = $_POST['telefon'];
  $email_subject = $_POST['subject'];
  $email_content = $_POST['vsebina'];

  $email_message = "";
  $email_message .= "Ime in priimek: ".clean_string($name)."\n";
  $email_message .= "Podjetje: ".clean_string($company)."\n";
  $email_message .= "Email: ".clean_string($email_from)."\n";
  $email_message .= "Telefon: ".clean_string($telephone)."\n\n\n";
  $email_message .= "Vsebina: \n\n".clean_string($email_content)."\n";

  $headers = 'From: '.$email_from."\r\n".
  'Reply-To: '.$email_from."\r\n" .
  'X-Mailer: PHP/' . phpversion();
  mail($email_to, $email_subject, $email_message, $headers);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" dir="ltr">
  <head>
    <title>Stin.si :: Kontakt</title>
    <link rel="icon"
        type="image/png"
        href="uploads/logo-only.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="title" content="Stin.si Kontakt">
    <meta name="description" content="Stin.si :: strojne inštalacije, ogrevanje, vodovod, ESCO, hlajenje, prezracevanje, klimatizacija, krovska dela, krovske storitve">
    <meta name="keywords" content="stin, stin.si, strojne inštalacije, ogrevanje, vodovod, ESCO, hlajenje, prezracevanje, klimatizacija, krovska dela, krovske storitve">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="language" content="English">
    <meta name="author" content="Marko Plaznik">

    <link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet">
    <link rel="stylesheet prefetch" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
    <link rel="stylesheet" href="css/global.css?v=1.0">
    <link rel="stylesheet" href="css/icon.min.css">
    <link rel="stylesheet" href="css/nav-white-bg.css">
    <style media="screen">
      #navbar .right.menu .item a {
        color: black;
        text-shadow: none;
      }
      .bold {
        font-weight: bold;
      }
      #content-wrapper {
        padding: 50px 50px;
      }
      #info-panel,
      #info-panel .content,
      .ui.horizontal.divider.header {
        font-size: 13px;
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

          <h1>Kontakt</h1>

          <div class="ui stackable two column grid">
            <div class="column" style="padding-left: 0 !important; padding-right: 0 !important;">
              <?php
              if (preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false)) { } else { ?>
                <iframe style="width: 100%; height: 100%; min-height: 200px" id="gmap_canvas" src="https://maps.google.com/maps?q=Trg%204.%20julija%2067&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
              <?php } ?>
            </div>
            <div class="column" id="info-panel">

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

            </div>
          </div>

          <h1>Kontaktni obrazec</h1>
          <form method="post" action="" class="ui form">
            <div class="ui stackable two column grid">
              <div class="column">
                  <div class="field">
                    <label>Ime in priimek</label>
                    <input type="text" name="name" placeholder="Ime in priimek" required>
                  </div>
                  <div class="field">
                    <label>Podjetje</label>
                    <input type="text" name="podjetje" placeholder="Podjetje" required>
                  </div>
                  <div class="field">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Email" required>
                  </div>
                  <div class="field">
                    <label>Telefon</label>
                    <input type="number" name="telefon" placeholder="Telefon" required>
                  </div>
              </div>
              <div class="column">
                <div class="field">
                  <label>Naslov sporočila</label>
                  <input type="text" name="subject" placeholder="Naslov sporočila" required>
                </div>
                <div class="field">
                  <label>Vsebina</label>
                  <textarea name="vsebina" required></textarea>
                </div>
              </div>
              <button name="emailform" class="ui button" type="submit">Pošlji sporočilo</button>
            </div>
          </form>

        <footer style="margin-top: 50px;">
          <div class="ui container">

            <div class="ui stackable two column grid" style="height: 100%">
              <div class="column" style="display: flex; justify-content: center; align-items: center; flex-direction: column">
                <img src="res/logo-2_optimized-248x100.png?v=1.1" style="width: auto; height: 60px">
                <br>
                <p style="font-size: 12px">© 2008-2016 Stin, d.o.o. Vse pravice pridržane</p>
              </div>
              <div class="column" style="display: flex; flex-direction: column; justify-content: center; align-items: center">
                <p> <span style="font-weight: bold">Telefon </span> +386-2-7070-750</p>
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
    <script type="text/javascript">
      $('.ui.accordion')
        .accordion();
    </script>
  </body>
</html>
