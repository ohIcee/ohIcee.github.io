<?php
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-113193592-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-113193592-1');
    </script>
    <meta charset="UTF-8">
    <meta name="description" content="Izbolšnik - Vozni redi za Izletnik">
    <meta name="keywords" content="Izletnik, vozni, red, vozni redi, izletnik vozni red, vozni redi izletnik, izbolšnik vozni red, vozni red izbolšnik, Izbolšnik">
    <link rel="canonical" href="http://byicee.xyz" />
    <meta name="robots" content="follow"/>

    <meta property="og:url" content="http://byicee.xyz/projects/Izbolsnik/">
    <meta property="og:image" content=""> <!-- TODO CREATE IMAGE -->
    <meta property="og:description" content="Vozni redi za Izletnik">
    <meta property="og:title" content="Izbolšnik">
    <meta property="og:site_name" content="Izbolšnik">
    <meta property="og:see_also" content="http://byicee.xyz/">

    <meta itemprop="name" content="Izbolšnik">
    <meta itemprop="description" content="Vozni redi za Izletnik">
    <meta itemprop="image" content=""> <!-- TODO CREATE IMAGE -->

    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="http://byicee.xyz/projects/Izbolsnik/">
    <meta name="twitter:title" content="Izbolšnik">
    <meta name="twitter:description" content="Vozni redi za Izletnik">
    <meta name="twitter:image" content=""> <!-- TODO CREATE IMAGE -->

    <title>Izbolsnik - Vozni redi</title>
    <link rel="stylesheet" href="css/index_design.css?ver=1.4">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="css/sidebar.min.css">
    <link rel="stylesheet" href="css/icon.min.css">
    <link rel="stylesheet" href="css/menu.min.css">
    <link rel="stylesheet" href="css/modal.min.css">
    <link rel="stylesheet" href="css/dimmer.min.css">
    <link rel="stylesheet" href="css/transition.min.css">
    <link rel="stylesheet" href="css/dropdown.min.css">
    <link rel="stylesheet" href="css/accordion.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <div id="header-wrapper">
      <div class="container">
        <i onclick="ToggleSideBar('toggle')" class="material-icons">menu</i>
        <h1 id="header-name">Izbolšnik <span style="font-size: 0.5em">zdaj Bolšago</span> </h1>
      </div>
    </div>

    <div class="ui left vertical inverted wide sidebar labeled menu">
      <?php
      if ($_SESSION['user_id'] == null) {
      ?>
      <a class="authenticate item">
        <div class="ui inverted segment">
          <div class="ui inverted accordion">
            <div id="login-title" class="title">
              <i class="dropdown icon"></i>
              Prijava
            </div>
            <div id="login-content" class="content">
              <form>
                <fieldset class="login-fieldset">
                  <input placeholder="Uporabniško Ime" autocomplete="username" type="text" id="login-username-input">
                  <input placeholder="Geslo" autocomplete="current-password" type="password" id="login-password-input">
                  <button id="login-submit" class="button" type="button" name="button">Prijavi se</button>
                </fieldset>
              </form>
              <p id="login-error"></p>
            </div>
            <div id="register-title" class="title">
              <i class="dropdown icon"></i>
              Registracija
            </div>
            <div id="register-content" class="content">
              <form>
                  <fieldset>
                    <input placeholder="Uporabniško Ime" type="text" id="register-username-input">
                    <input placeholder="E-Mail" autocomplete="email" type="text" id="register-email-input">
                    <input placeholder="Geslo" autocomplete="new-password" type="password" id="register-password-input">
                    <input placeholder="Ponovi geslo" autocomplete="new-password" type="password" id="register-confirm-password-input">
                    <button id="register-submit" class="button" type="button" name="button">Registriraj se</button>
                  </fieldset>
                </form>
                <p id="register-error"></p>
            </div>
          </div>
        </div>
      </a>
      <a class="authenticate item">Prosimo prijavite se za več možnosti</a>
      <div id="authentication-loader" class="loader"></div>
    <?php } else { ?>
      <a class="item"> Pozdravljeni, <?php echo $_SESSION['user_username']; ?></a>
      <a class="item">
        <button id="home-tab-button" class="button button-clear">Domov</button>
        <button id="history-tab-button" class="button button-clear">Poglej zgodovino relacij</button>
      </a>
      <a class="item"><button onclick="window.location.replace('php/Logout.php')" class="button" type="button" name="button">Odjavi se</button></a>
    <?php } ?>
    </div>

    <div class="pusher">
      <div id="main" class="container">
        <div id="relations-input-wrapper">
          <div class="row">
            <div class="column column-45">
              <label for="origin-relation-input" id="relation-select-label">Izberite vstopno postajo</label>
              <input id="origin-relation-input" type="text" name="origin-relation">
            </div>
            <div class="column column-45">
              <label for="destination-relation-input" id="relation-select-label">Izberite izstopno postajo</label>
              <input id="destination-relation-input" type="text" name="destination-relation">
            </div>
          </div>

          <div class="row">
            <div class="column">
              <label for="relation-date-input">Izberite datum</label>
              <input style="width: 100%;" type="text" id="relation-date-input" name="relation-date">
            </div>
            <div id="switch-relations-column" class="column">
              <label>V povratni smeri</label>
              <i class="material-icons">compare_arrows</i>
            </div>
            <div class="column">
              <button id="search-relations-button" type="button" name="button" class="button">Išči</button>
            </div>
          </div>
          <?php if (isset($_SESSION['user_id'])) { ?>
          <p id="fav-text" class="fav-text"></p>
        <?php } ?>
        </div>
        <div id="relations-loader" class="loader"></div>
        <div class="error-wrapper">
          <p style="font-weight: bold">Prišlo je do napake! (<span class="error-code-text"></span>)</p>
          <p class="error-text">Error 500: Problem s strani Izletnik <span class="small-text">(možni problemi: neveljavna relacija, problem pridobitev podatkov)</span></p>
          <p class="error-text">Error 0: Problem s strani Izbolšnik</p>
          <button onclick="UpdateValues()" type="button" name="button">Poskusi ponovno</button>
        </div>

        <div style="display: none; min-height: 800px;" id="relation-history-wrapper">
          <h1>Zgodovina Relacij</h1>
          <h1 style="display: none">Nimate zgodovine relacij!</h1>
          <table id="relation-history">
            <thead>
              <tr>
                <th>Vstopna Postaja</th>
                <th>Izstopna Postaja</th>
                <th>Datum in Čas</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>

        <div id="relations-wrapper">
          <table id="relations">
            <thead>
              <tr>
                <th>Odhod</th>
                <th>Prihod</th>
                <th>Čas vožnje</th>
                <th>Cena vožnje</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>

        <footer>
          <div id="fine-print-wrapper">
            <h2>Ne tako drobni drobni tisk</h2>
            <p><span class="fine-print-nmr">1</span>   Ta stran je bila narejena z razlogom, da je prijazna mobilnim napravam, saj trenutna izletnik stran ni optimirana (29.1.2018). </p>
            <p><span class="fine-print-nmr">1.1</span> Ta spletna stran ni podprta z Izletnikom in ne odražajo mnenj o njihovi spletni strani.                                        </p>
            <p><span class="fine-print-nmr">1.2</span> Uporabljene so bile samo javne informacije iz spletne strani <a href="https://www.e-karta.si/bus4i_vr/izletnik/">izletnik</a>  </p>
          </div>
        </div>
      </footer>
    </div>

    <div id="snackbar">Tukaj gre tekst!</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="js/sidebar.min.js" charset="utf-8"></script>
    <script src="js/modal.min.js" charset="utf-8"></script>
    <script src="js/index_script.js?ver=1.4" charset="utf-8"></script>
    <script src="js/dimmer.min.js" charset="utf-8"></script>
    <script src="js/dropdown.min.js" charset="utf-8"></script>
    <script src="js/accordion.min.js" charset="utf-8"></script>
    <script src="js/authentication_script.js" charset="utf-8"></script>

    <script type="text/javascript">
    function setCookie(key, value) {
        var expires = new Date();
        expires.setTime(expires.getTime() + (value * 24 * 60 * 60 * 1000));
        document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
    }

    function getCookie(key) {
        var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
        return keyValue ? keyValue[2] : null;
    }
    </script>

  </body>
</html>
