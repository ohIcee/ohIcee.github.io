<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

$SelectedCategoryID = $_POST["category-sort-option"] == null ? $SelectedCategoryID = "1" : $_POST["category-sort-option"];

?>
<!doctype html>
<html lang="en">
  <head>
    <title>Steling Website</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/gallery_design.css">
    <link rel="stylesheet" href="css/footer_design.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  </head>
  <body id="galerija">

    <?php echo "<div class='tempCatName'>" . $SelectedCategoryID . "</div>"; ?>

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
              <hr>
              <ul class="nav navbar-nav">
                  <li onclick="window.location.href='index.php'" class="nav-item"><a class="nav-link" href="#page-top">Domov</a></li>
                  <li onclick="window.location.href='gallery.php'" class="nav-item"><a class="nav-link" href="#galerija">Galerija</a></li>
              </ul>
            </div>
        </div>
    </nav>

    <section id="images-section" class="container py-5">
      <h1>Galerija</h1><br>

      <form action="gallery.php" method="post">
        <div class="category-sort-wrapper row align-items-center">
          <div class="col">
            <h6>Sortiraj po kategoriji</h6>
          </div>
          <div class="col-9">
            <select onchange="this.form.submit()" name="category-sort-option" class="nice-select category-select-dropdown"></select>
          </div>
        </div>
      </form>

      <div class="img-grid">
        <div id="grid" data-columns></div>
      </div>

    </section>

    <footer id="myFooter">
      <div class="container">
        <div class="row">
          <div class="col-sm-3">
            <h2 class="logo"><a href="#"> <img src="../StelingWebsite/res/steling_logo.png" alt=""> </a></h2>
          </div>
          <div class="col-sm-3">
            <h5>Povezave</h5>
            <ul>
              <li><a href="index.php">Domov</a></li>
              <li><a onclick="window.location.href='gallery.php'" href="#galerija">Galerija</a></li>
            </ul>
          </div>
          <div class="col-sm-3">
            <h5>Kontakt</h5>
            <ul>
              <li><a>STELING Peter Plaznik S.P.</a></li>
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
        <a href="https://www.byicee.xyz">Made by Marko Plaznik <small>byicee.xyz</small></a>
      </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/jquery.js" charset="utf-8"></script>
    <script src="js/jquery.nice-select.min.js" charset="utf-8"></script>
    <script src="js/GetDropdownOptions.js" charset="utf-8"></script>
    <script src="js/gallery_script.js" charset="utf-8"></script>
    <script src="js/salvattore.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>
