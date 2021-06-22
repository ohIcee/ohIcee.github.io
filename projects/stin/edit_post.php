<?php
session_start();
if ($_SESSION["authenticated"] != true) {
  header("Location: admin.php");
  return;
}

require_once("php/DBConnect.php");
require_once 'php/HelperFunctions.php';

if (isset($_POST['edit'])) {

  function editNovica() {
    global $db;

    $naslov = $_POST["novice-naslov"];
    $datumDodajanja = $_POST["novice-datum"];
    $podnaslov = $_POST["novice-podnaslov"];
    $vsebina = $_POST["novice-vsebina"];
    $folder = "uploads/novice/";

    $sql = "SELECT slika FROM novice WHERE ID=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $_GET['id']);
    $result = $stmt->execute();
    $row = $stmt->fetch();
    $slika = $row['slika'];

    if (!empty($_FILES['novice-slika']['tmp_name'])) {
      unlink('uploads/novice/' . $slika);

      // Create Appropriate Unique File Name for Image
      $FileNameParts = explode(".", $_FILES['novice-slika']['name']);
      $NewFileName = $FileNameParts[0] . "-" . date('Ymd') . "-" . rand(1, 15) . ".jpg";
      $slika = $NewFileName;

      // Compress and upload Image
      CompressImage($_FILES['novice-slika']['tmp_name'], "$folder".$NewFileName, 50);
    }

    $sql = "UPDATE novice SET naslov=:naslov, datumdodajanja=:datum, podnaslov=:podnaslov, vsebina=:vsebina, slika=:slika WHERE ID=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':naslov', $naslov);
    $stmt->bindValue(':datum', $datumDodajanja);
    $stmt->bindValue(':podnaslov', $podnaslov);
    $stmt->bindValue(':vsebina', $vsebina);
    $stmt->bindValue(':slika', $slika);
    $stmt->bindValue(':id', $_GET['id']);

    $endResult = $stmt->execute();

    if (isset($_POST['remove-photo'])) {
      $sql = "UPDATE novice SET slika=:slika WHERE ID=:id";
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':slika', '');
      $stmt->bindValue(':id', $_GET['id']);
      $result = $stmt->execute();

      unlink($folder . $slika);
    }

    if ($endResult) {
      // header("Location: novica.php?id=".$_GET['id']);
      header("Location: index.php");
    }

  }

  function editReferenca() {
    global $db;

    $naslov = $_POST['referenca-naslov'];
    $datumDodajanja = $_POST['referenca-datum'];
    $vsebina = $_POST['referenca-vsebina'];
    $folder = 'uploads/reference/';

    $sql = "SELECT COUNT(slika) as num FROM referenca_slike WHERE referenca_ID=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $_GET['id']);
    $result = $stmt->execute();
    $count = $stmt->fetch();
    $count = $count['num'];

    $slike = $_FILES['add-photos'];
    if($slike['error'] > UPLOAD_ERR_OK) {
      $images = array();

      // Dodaj Slike
      $result = "";
      foreach ($slike['tmp_name'] as $key => $value) {

        if ($slike['name'][$key] == '') {
          continue;
        }

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
          $stmt->bindValue(':id', $_GET['id']);
          $result = $stmt->execute();
      }

    }

    for ($i=0; $i < $count; $i++) {

      if (isset($_POST['remove-photo-'.$i])) {

        $rowID = $_POST['remove-photo-'.$i];

        $sql = "SELECT slika FROM referenca_slike WHERE ID=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $rowID);
        $result = $stmt->execute();
        $row = $stmt->fetch();

        unlink($folder . $row['slika']);

        $sql = "DELETE FROM referenca_slike WHERE ID=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $rowID);
        $result = $stmt->execute();

        continue;
      }

      $sql = "SELECT ID, slika FROM referenca_slike WHERE referenca_ID=:id";
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':id', $_GET['id']);
      $result = $stmt->execute();
      $row = $stmt->fetch();

      if (!empty($_FILES['referenca-slika-'.$i]['tmp_name'])) {
        unlink('uploads/reference/'.$row['slika']);

        // Create Appropriate Unique File Name for Image
        $FileNameParts = explode(".", $_FILES['referenca-slika-'.$i]['name']);
        $NewFileName = $FileNameParts[0] . "-" . date('Ymd') . "-" . rand(1, 15) . ".jpg";
        $slika = $NewFileName;

        // Compress and upload Image
        CompressImage($_FILES['referenca-slika-'.$i]['tmp_name'], "$folder".$NewFileName, 50);

        $sql = "UPDATE referenca_slike SET slika=:slika WHERE ID=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':slika', $slika);
        $stmt->bindValue(':id', $row['ID'], PDO::PARAM_INT);
        $stmt->execute();
      }
    }

    $sql = "UPDATE reference SET naslov=:naslov, datumdodajanja=:datum, vsebina=:vsebina WHERE ID=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':naslov', $naslov);
    $stmt->bindValue(':datum', $datumDodajanja);
    $stmt->bindValue(':vsebina', $vsebina);
    $stmt->bindValue(':id', $_GET['id']);

    $result = $stmt->execute();
    if ($result) {
      // header("Location: referenca.php?id=".$_GET['id']);
      header("Location: index.php");
    }

  }

  if ($_GET['type'] == 'novica') { editNovica(); }
  else { editReferenca(); }

}

if (isset($_POST['cancel'])) {
  header("Location: admin.php");
  return;
}

$sql = "";
$slike;
if ($_GET['type'] == 'novica') {
  $sql = "SELECT naslov, vsebina, datumdodajanja, podnaslov, slika FROM novice WHERE ID=:id";
} else {
  $sql = "SELECT naslov, vsebina, datumdodajanja FROM reference WHERE ID=:id";
}
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $_GET['id']);
$result = $stmt->execute();
$article = $stmt->fetch();

if ($_GET['type'] == 'referenca') {
  $sql = "SELECT ID, slika FROM referenca_slike WHERE referenca_ID=:id";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':id', $_GET['id']);
  $result = $stmt->execute();
  $slike = $stmt->fetchAll();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Stin.si :: strojne inštalacije :: ogrevanje :: vodovod</title>
    <link rel="icon"
        type="image/png"
        href="uploads/logo-only.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="robots" content="noindex"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vivus/0.4.4/vivus.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet">
    <link rel="stylesheet prefetch" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/admin_design.css">
    <link rel="stylesheet" href="css/icon.min.css">
    <style media="screen">
      @media (max-width: 600px) {
        #slika {
          width: 100% !important;
        }
      }

      .ui.basic.orange.button:hover { background-color: #f26202 !important; color: white !important; }
    </style>
  </head>
  <body>
    <div class="ui container" style="min-height: 100vh; display: flex; justify-content: center; align-items: center; flex-direction: column">

      <h1>UREJANJE <?php echo $_GET['type']; ?></h1>

      <form method="post" enctype="multipart/form-data" class="ui form" style="width: 100%">

      <?php if ($_GET['type'] == 'novica') { ?>

          <div class="field">
            <label>Naslov</label>
            <input type="text" name="novice-naslov" value="<?php echo $article['naslov']; ?>">
          </div>
          <div class="field">
            <label>Podnaslov</label>
            <input type="text" name="novice-podnaslov" value="<?php echo $article['podnaslov']; ?>">
          </div>
          <div class="field">
            <label>Datum</label>
            <input type="date" name="novice-datum" value="<?php echo $article['datumdodajanja']; ?>">
          </div>

          <div class="field">
            <label>Vsebina</label>
            <textarea name="novice-vsebina"><?php echo $article['vsebina']; ?></textarea>
          </div>

          <div class="field">

            <div class="ui equal width grid">
              <div class="column">
                <label>Slika</label>
                <?php if ($article['slika'] != null) {
                   echo '<img id="slika" class="ui small image" style="width: 300px" src="uploads/novice/'.$article['slika'].'"/>';
                } ?>
              </div>
              <div class="column">
                <label>Spremeni Sliko</label>
                <input accept="image/*" type="file" name="novice-slika">
                <br><br>
                <div class="ui toggle checkbox">
                  <input type="checkbox" name="remove-photo">
                  <label>Odstrani sliko</label>
                </div>
              </div>
            </div>

          </div>

        <?php } else { ?>

          <div class="field">
            <label>Naslov</label>
            <input type="text" name="referenca-naslov" value="<?php echo $article['naslov']; ?>">
          </div>

          <div class="field">
            <label>Datum</label>
            <input type="date" name="referenca-datum" value="<?php echo $article['datumdodajanja']; ?>">
          </div>

          <div class="field">
            <label>Vsebina</label>
            <textarea name="referenca-vsebina"><?php echo $article['vsebina']; ?></textarea>
          </div>

          <div class="field">

            <?php

            foreach ($slike as $key => $value) {
              echo '

              <div class="ui equal width grid">
                <div class="column">
                  <img id="slika" class="ui small image" style="width: 300px" src="uploads/reference/'.$slike[$key]['slika'].'"/>
                </div>
                <div class="column">
                  <label>Spremeni Sliko</label>
                  <input accept="image/*" type="file" name="referenca-slika-'.$key.'">
                  <br><br>
                  <div class="ui toggle checkbox">
                    <input type="checkbox" name="remove-photo-'.$key.'" value="'.$slike[$key]['ID'].'">
                    <label>Odstrani sliko</label>
                  </div>
                </div>
              </div>

              ';
            }

            ?>

          </div>

          <div class="field">
            <label>Dodaj Slike</label>
            <input accept="image/*" type="file" name="add-photos[]" multiple>
          </div>

        <?php } ?>

        <button class="ui basic green button" type="submit" name="edit">Končaj urejanje</button>
        <button class="ui basic red button" type="submit" name="cancel">Prekliči</button>
      </form>


    </div>

    <style media="screen">
      .ui.equal.width.grid {
        transition-duration: 0.3s;
      }
      .remove {
        transition-duration: 0.3s;
        background-color: rgba(199, 56, 49, 0.75);
      }
    </style>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
    <!-- <script src="js/admin_script.js" charset="utf-8"></script> -->
    <script type="text/javascript">
      $('.ui.checkbox').checkbox({
        onChecked: function() {
          $(this).closest('.ui.equal.width.grid').addClass('remove');
        },
        onUnchecked: function() {
          $(this).closest('.ui.equal.width.grid').removeClass('remove');
        },
      });
    </script>
  </body>
</html>
