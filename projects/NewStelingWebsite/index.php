<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
require('php/CheckLogin.php');
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Steling Website</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Steling S.P. Iščete ravno to, kar delamo mi?">
    <meta name="application-name" content="Steling S.P.">
    <meta name="referrer" content="unsafe-url">
    <meta name="robots" content="index,follow,noodp">
    <meta name="googlebot" content="index,follow">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/index_design.css">
    <link rel="stylesheet" href="css/footer_design.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

    <style media="screen">
      @media all and (-ms-high-contrast:none) {
        *::-ms-backdrop, #products-section {
          max-height: 500px;
        }
      }
    </style>

  </head>
  <body id="page-top">

    <!-- Navbar -->
    <nav id="main-nav" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <span>STELING</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
              <ul class="nav navbar-nav">
                <?php require('php/LoadNavButtons.php'); ?>
              </ul>
              <hr>
              <ul class="nav navbar-nav">
                  <li class="nav-item"><a class="nav-link" href="#page-top">Domov</a></li>
                  <li class="nav-item"><a class="nav-link" href="#about-company-section">O podjetju</a></li>
                  <li class="nav-item"><a class="nav-link" href="#products-section">Izdelki</a></li>
                  <li class="nav-item"><a class="nav-link" href="#kontakt">Kontakt</a></li>
                  <li onclick="window.location.href='gallery.php'" class="nav-item"><a class="nav-link" href="#galerija">Galerija</a></li>
              </ul>
            </div>
        </div>
    </nav>

    <section id="introduction-section" class="py-5">
      <div class="container">
        <img class="logo" src="../StelingWebsite/res/steling_logo.png" alt="">
        <h3>Iščete ravno to, kar delamo mi?</h3>
        <a class="btn btn-default get-interested-btn" href="#about-company-section">Pozanimajte se!</a>
      </div>
    </section>

    <!-- O podjetju -->
    <section id="about-company-section" class="container py-5">
      <h1>O podjetju</h1>

      <p>Naše podjetje je bilo <span class="font-weight-bold">ustanovljeno leta 2000</span>, vse od takrat pa ponujamo izdelke za testiranjekabelskih setov in naprav za termično označevanje konektorjev iz plastičnihmas.</p>
      <p>Izdelujemo tudi serijske izdelke manjših dimenzij iz različnih materijalov in z vašimi načrti. Izdelke izdelujemo iz barvnih kovin in vseh vrst umetnih mas.V proizvodnji imamo dva CNC rezkalnika in eno CNC stružnico</p>
    </section>

    <!-- Produkti -->
    <section id="products-section" class="container py-5">
      <h1>Izdelki</h1>
      <p>Izdelujemo vse vrste izdelkov iz umetne mase in barvnih kovin (CNC rezkanje in CNC struženje). Konstruiramo razna orodja in priprave za namen kontrole kvalitete kabelskih snopov. Izdelujemo pa tudi izdelke z vaših načrtov.</p>
      <?php
      $images = array();
      $files = glob("uploads/*.*");
      for ($i=0; $i<3; $i++) {
        $image = $files[$i];
        array_push($images, $image);
      }
      ?>

      <div class="row">
        <div class="col-sm">
          <?php echo '<div><img class="gallery-img" title="Steling S.P." src="'. $images[0] .'" /></div>'; ?>
        </div>
        <div class="col-sm">
          <?php echo '<div><img class="gallery-img" title="Steling S.P." src="'. $images[1] .'" /></div>'; ?>
        </div>
        <div class="col-sm">
          <?php echo '<div><img class="gallery-img" title="Steling S.P." src="'. $images[2] .'" /></div>'; ?>
        </div>
      </div>

      </div>

    </section>

    <!-- Kontakt -->
    <section id="kontakt" class="container py-5">
      <h1>Kontakt</h1><br>
      <div class="row">
        <div class="col-sm">
          <div class="card">
            <div class="card-body">
              <h3>STELING</h3>
              <p>Peter Plaznik S.P.</p>
              <p>2392 Mežica</p>
              <p>Slovenija</p>
              <p>D.Š.: SI37524810</p>
              <p>Sem davčni zavezanec</p>
              <p>Tel.: 028236136, 028235659</p>
              <p>Fax.: 028277663</p>
              <p>Email: <a href="mailto:steling@t-2.net">steling@t-2.net</a></p>
              <p>TRR: SI56 0245 2009 0096 061<br><small class="text-muted"><a href="https://www.nlb.si/">Nova Ljubljanska banka d.d.</a></small></p>
            </div>
          </div>
        </div>
        <div class="col-sm">
          <div id="gmaps">
            <div id="gmaps_id">
                <iframe id="gmaps_map" frameborder="0" src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJ7xvme-L4b0cR-6HJ12UsSvA&key=AIzaSyCmrYzaM3fdJB5ab9f6wOGFjs6WURo00pc" allowfullscreen class="scrolloff"></iframe>
            </div>
          </div>
        </div>
      </div>

    </section>

    <!-- LOGIN Modal -->
    <div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="LoginModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="LoginModalLabel">Prijava</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="login-email-input">Email naslov</label>
              <input type="email" class="form-control" id="login-email-input" aria-describedby="LoginEmail" placeholder="Vnesi email">
            </div>
            <div class="form-group">
              <label for="login-password-input">Geslo</label>
              <input type="password" class="form-control" id="login-password-input" placeholder="Geslo">
            </div>
            <div id="login-modal-error" class="alert alert-danger" role="alert">
              Tukaj se pokaže morebitna napaka.
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Prekliči</button>
            <button id="login-submit-button" type="button" class="btn btn-primary">Prijavi</button>
          </div>
        </div>
      </div>
    </div>

    <!-- REGISTER Modal -->
    <div class="modal fade" id="RegisterModal" tabindex="-1" role="dialog" aria-labelledby="RegisterModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="RegisterModalLabel">Registracija</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="register-email-input">Email naslov</label>
              <input type="email" class="form-control" id="register-email-input" aria-describedby="RegisterEmail" placeholder="Vnesi email">
            </div>
            <div class="form-group">
              <label for="register-password-input">Geslo</label>
              <input type="password" class="form-control" id="register-password-input" placeholder="Geslo">
            </div>
            <div class="form-group">
              <label for="register-confirm-password-input">Potrdi Geslo</label>
              <input type="password" class="form-control" id="register-confirm-password-input" placeholder="Potrdi Geslo">
            </div>
            <div class="form-check">
              <label class="form-check-label">
                <input onclick="ToggleShowPassword()" class="form-check-input" type="checkbox">
                Pokaži geslo
              </label>
            </div>
            <div id="register-modal-error" class="alert alert-danger" role="alert">
              Tukaj se pokaže morebitna napaka.
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Prekliči</button>
            <button id="register-submit-button" type="button" class="btn btn-primary">Registriraj</button>
          </div>
        </div>
      </div>
    </div>

    <footer id="myFooter">
      <div class="container">
        <div class="row">
          <div class="col-sm-3">
            <h2 class="logo"><a href="#"> <img src="../StelingWebsite/res/steling_logo.png" alt=""> </a></h2>
          </div>
          <div class="col-sm-3">
            <h5>Povezave</h5>
            <ul>
              <li><a href="#page-top">Domov</a></li>
              <li><a href="#about-company-section">O podjetju</a></li>
              <li><a href="#products-section">Izdelki</a></li>
              <li><a href="#kontakt">Kontakt</a></li>
              <li><a onclick="window.location.href='gallery.php'" href="#galerija">Galerija</a></li>
            </ul>
          </div>
          <div class="col-sm-3">
            <h5>Kontakt</h5>
            <ul>
              <li><a>STELING</a></li>
              <li><a>Peter Plaznik S.P.</a></li>
              <li><a>2392 Mežica</a></li>
              <li><a>Slovenija</a></li>
              <li><a>D.Š.: SI37524810</a></li>
              <li><a>Sem davčni zavezanec</a></li>
              <li><a>Tel.: 028236136, 028235659</a></li>
              <li><a>Fax.: 028277663</a></li>
              <li><a>Email: <a href="mailto:steling@t-2.net">steling@t-2.net</a></a></li>
              <li><a>TRR: SI56 0245 2009 0096 061<br><small class="text-muted"><a href="https://www.nlb.si/">Nova Ljubljanska banka d.d.</a></small></a></li>
            </ul>
          </div>
          <div class="col-sm-3">
            <h5>Račun</h5>
            <ul>
              <?php require('php/LoadNavButtons.php'); ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="footer-copyright">
        <p>© 2017 Steling - Peter Plaznik S.P. </p>
      </div>
    </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="js/index_script.js" charset="utf-8"></script>
    <script src="js/salvattore.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>
