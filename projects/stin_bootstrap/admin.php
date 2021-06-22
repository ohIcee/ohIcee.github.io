<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once("php/DBConnect.php");

if (isset($_POST["login_btn"])) {
  $inputPass = $_POST["password"];

  $sql = "SELECT password FROM admin";
  $stmt = $db->prepare($sql);
  $result = $stmt->execute();
  $correctPass = $stmt->fetch()[0];

  if (password_verify($inputPass, $correctPass)) {
    $_SESSION["authenticated"] = true;
  }
}

if (isset($_GET['logout'])) {
  $_SESSION["authenticated"] = false;
  header("Location: admin.php");
}

if (isset($_POST['edit-novica']) && isset($_POST['novice-dropdown'])) {
  if ($_POST['novice-dropdown'] != '') {
    header("Location: edit_post.php?type=novica&id=" . $_POST['novice-dropdown']);
    return;
  }
}

if (isset($_POST['edit-referenca']) && isset($_POST['reference-dropdown'])) {
  if ($_POST['reference-dropdown'] != '') {
    header("Location: edit_post.php?type=referenca&id=" . $_POST['reference-dropdown']);
    return;
  }
}

require_once 'php/HelperFunctions.php';

if (isset($_POST["btn-dodaj-novico"])) {

  $naslov = $_POST["novice-naslov"];
  $datumDodajanja = $_POST["novice-datum"];
  $podnaslov = $_POST["novice-podnaslov"];
  $vsebina = $_POST["novice-vsebina"];
  $slika = $_FILES['novice-slika']['tmp_name'];

  $ImageName = "";
  $folder = "uploads/novice/";

  if (!empty($slika)) {
    // Create Appropriate Unique File Name for Image
    $FileNameParts = explode(".", $_FILES["novice-slika"]["name"]);
    $NewFileName = $FileNameParts[0] . "-" . date('Ymd') . "-" . rand(1, 15) . ".jpg";
    $ImageName = $NewFileName;

    // Compress and upload Image
    CompressImage($slika, "$folder".$NewFileName, 50);
  }

  $sql = "INSERT INTO novice (naslov, datumdodajanja, podnaslov, vsebina, slika) VALUES (:naslov, :datum, :podnaslov, :vsebina, :slika)";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':naslov', $naslov);
  $stmt->bindValue(':datum', $datumDodajanja);
  $stmt->bindValue(':podnaslov', $podnaslov);
  $stmt->bindValue(':vsebina', $vsebina);
  $stmt->bindValue(':slika', $ImageName);

  $result = $stmt->execute();
  if ($result) {
    // Prevent Form Resubmittion
    header("Location: " . $_SERVER['REQUEST_URI']);
    echo "<h1>Novica " . $naslov . " dodana!</h1>";
  }
}

if (isset($_POST["btn-dodaj-referenco"])) {

  $naslov = $_POST["reference-naslov"];
  $datumDodajanja = $_POST["reference-datum"];
  $vsebina = $_POST["reference-vsebina"];
  $slike = $_FILES['reference-slike'];

  $ImageName = "";
  $folder = "uploads/reference/";

  $sql = "INSERT INTO reference (naslov, datumdodajanja, vsebina) VALUES (:naslov, :datum, :vsebina)";
  $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':naslov', $naslov);
  $stmt->bindValue(':datum', $datumDodajanja);
  $stmt->bindValue(':vsebina', $vsebina);

  $result = $stmt->execute();
  if ($result) {
    $id = $db->lastInsertId();

    if($slike['error'] > UPLOAD_ERR_OK) {

      $images = array();

      // Dodaj Slike
      $result = "";
      foreach ($slike['tmp_name'] as $key => $value) {

        // Create Appropriate Unique File Name for Image
        $FileNameParts = explode(".", $slike['name'][$key]);
        $NewFileName = $FileNameParts[0] . "-" . date('Ymd') . "-" . rand(1, 15) . ".jpg";
        $ImageName = $NewFileName;

        array_push($images, $ImageName);

        // Compress and upload Image
        CompressImage($value, "$folder".$NewFileName, 50);
      }

      $sql = "INSERT INTO referenca_slike (slika, referenca_ID) VALUES(:slika, :id)";
      foreach ($images as $key => $value) {
          $stmt = $db->prepare($sql);
          $stmt->bindValue(':slika', $value);
          $stmt->bindValue(':id', $id);
          $result = $stmt->execute();
      }

      if ($result) {
        // Prevent Form Resubmittion
        header("Location: " . $_SERVER['REQUEST_URI']);
        echo "<h1>Referenca " . $naslov . " dodana!</h1>";
      }
    } else {
      header("Location: " . $_SERVER['REQUEST_URI']);
      echo "<h1>Referenca " . $naslov . " napaka pri dodajanju!</h1>";
    }
  } else {
    $sql = "DELETE FROM reference WHERE ID=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    header("Location: " . $_SERVER['REQUEST_URI']);
    echo "<h1>Referenca " . $naslov . " napaka pri dodajanju!</h1>";
  }

}

if (!isset($_POST['novice-naslov'])) { $_POST['novice-naslov'] = ""; }
if (!isset($_POST['novice-podnaslov'])) { $_POST['novice-podnaslov'] = ""; }
if (!isset($_POST['novice-vsebina'])) { $_POST['novice-vsebina'] = ""; }

if (!isset($_POST['reference-naslov'])) { $_POST['reference-naslov'] = ""; }
if (!isset($_POST['reference-vsebina'])) { $_POST['reference-vsebina'] = ""; }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Stin.si :: strojne inštalacije :: ogrevanje :: vodovod</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="robots" content="noindex"/>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/vivus/0.4.4/vivus.min.js"></script>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
  <link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet">
  <link rel="stylesheet prefetch" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
  <link rel="stylesheet" href="css/admin_design.css">
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/icon.min.css">
</head>

<body>
  <div class="ui container" style="min-height: 100vh; display: flex; justify-content: center; align-items: center; flex-direction: column">
    <?php if ($_SESSION['authenticated'] != true) { ?>

    <h1>Prijava</h1>
    <form method="post" class="ui form">
      <div class="field">
        <label>Geslo</label>
        <input type="password" name="password" placeholder="Geslo">
      </div>
      <button class="ui button" name="login_btn" type="submit">Prijava</button>
    </form>

    <?php } else { ?>

    <div style="width: 100%" class="ui stackable two column grid">

      <div id="novice-clm" class="column">

        <h1>Novice</h1>

        <section id="upravljanje-novic">
          <h4>Upravljanje novic</h4>

          <form method="post">
            <div id="novice-dropdown" class="ui selection dropdown">
              <input type="hidden" name="novice-dropdown">
              <i class="dropdown icon"></i>
              <div class="default text"></div>
              <div class="menu"></div>
            </div>
            <br> <br>
            <button id="remove-novica-btn" class="ui basic red button">Izbriši novico</button>
            <button id="edit-novica-btn" type="submit" name="edit-novica" class="ui button">Uredi novico</button>
            <div id="novica-remove-success" class="ui success message">
              <i onclick="hide('novica-remove')" class="close icon"></i>
              <div class="header">
                Novica je bila uspešno izbrisana!
              </div>
            </div>
          </form>
        </section>

        <br><br>

        <section id="dodajanje-novic">
          <h4>Dodajanje</h4>

          <form enctype="multipart/form-data" method="post" class="ui form">

            <div class="field">
              <label>Naslov</label>
              <input value="<?php echo $_POST["novice-naslov"]; ?>" type="text" name="novice-naslov" placeholder="Naslov" required>
            </div>

            <div class="field">
              <label>Datum dodajanja</label>
              <input id="izbrani-datum" type="date" name="novice-datum" required>
            </div>

            <div class="field">
              <label>Podnaslov</label>
              <input value="<?php echo $_POST["novice-podnaslov"]; ?>" type="text" name="novice-podnaslov" placeholder="Podnaslov" required>
            </div>

            <div class="field">
              <label>Vsebina</label>
              <textarea value="<?php echo $_POST["novice-vsebina"]; ?>" type="text" name="novice-vsebina" placeholder="Vsebina" required></textarea>
            </div>

            <div class="field">
              <label>Slika</label>
              <input accept="image/*" type="file" name="novice-slika">
            </div>

            <button class="ui green button" name="btn-dodaj-novico" type="submit">Dodaj novico</button>
          </form>
        </section>

      </div>

      <div id="reference-clm" class="column">

        <h1>Reference</h1>

        <section id="upravljanje-referenc">
          <h4>Upravljanje referenc</h4>

          <form method="post">
            <div id="reference-dropdown" class="ui selection dropdown">
              <input type="hidden" name="reference-dropdown">
              <i class="dropdown icon"></i>
              <div class="default text"></div>
              <div class="menu"></div>
            </div>
            <br> <br>
            <button id="remove-referenca-btn" class="ui basic red button">Izbriši referenco</button>
            <button id="edit-referenca-btn" type="submit" name="edit-referenca" class="ui button">Uredi referenco</button>
            <div onclick="hide('referenca-remove')" id="referenca-remove-success" class="ui success message">
              <i class="close icon"></i>
              <div class="header">
                Referenca je bila uspešno izbrisana!
              </div>
            </div>
          </form>
        </section>

        <br><br>

        <section id="dodajanje-referenc">
          <h4>Dodajanje</h4>

          <form enctype="multipart/form-data" method="post" class="ui form">

            <div class="field">
              <label>Naslov</label>
              <input value="<?php echo $_POST["reference-naslov"]; ?>" type="text" name="reference-naslov" placeholder="Naslov" required>
            </div>

            <div class="field">
              <label>Datum dodajanja</label>
              <input id="izbrani-datum2" type="date" name="reference-datum" required>
            </div>

            <div class="field">
              <label>Vsebina</label>
              <textarea value="<?php echo $_POST["reference-vsebina"]; ?>" type="text" name="reference-vsebina" placeholder="Vsebina" required></textarea>
            </div>

            <div class="field">
              <label>Slike (prva izbrana bo izpostavljena)</label>
              <input accept="image/*" type="file" name="reference-slike[]" multiple>
            </div>

            <button class="ui green button" name="btn-dodaj-referenco" type="submit">Dodaj referenco</button>
          </form>

        </section>

      </div>

      <br>
      <a href="index.php">Domov</a>
      <a href="admin.php?logout">Odjava</a>

    </div>

    <?php } ?>

  </div>

  <script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
  <script src="js/admin_script.js" charset="utf-8"></script>
</body>

</html>
