<?php
session_start();

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require('php/CheckLogin.php');
require('php/DBConnect.php');

require_once("vendor/autoload.php");
\Tinify\setKey("i3HquCku3FROB-esoSwQvx0FjaGQySfA");

if ($_SESSION['email'] == null || $_SESSION['email'] == "") {
  echo "Niste prijavljeni! <a href='index.php'>Domov</a>";
  exit();
}

if (isset($_POST['submit-category-remove'])) {
  $categoryID = $_POST['delete-category-option'];
  $sql = "DELETE FROM categories WHERE id='$categoryID'";
  if ($db->query($sql) == TRUE) {
    echo "Succesfully deleted category from DB.";
  } else {
    echo "<span style='color: red'>Failed to delete category from DB.</span>";
  }
}

if (isset($_POST['submit-category-add'])) {
  $categoryName = $_POST['add-category-name'];
  $sql = "INSERT INTO categories (name) VALUES ('$categoryName')";
  if ($db->query($sql) == TRUE) {
    echo "Succesfully added category!";
  } else {
    echo "<span style='color: red'>Failed to add category!</span>";
  }
  mysqli_close($db);
}

// UPLOAD FILE ONTO SERVER
if (isset($_POST['submit-file-upload'])) {
  $supported_image = array('gif', 'jpg', 'jpeg', 'png');

	if (isset($_FILES['myfile']['name'])
	&& (0 == $_FILES['myfile']['error'])) {

		$src_file_name = $_FILES['myfile']['name'];

		$ext = strtolower(pathinfo($src_file_name,
		PATHINFO_EXTENSION));

		if (in_array($ext, $supported_image)) {
			if (!file_exists(getcwd(). '/uploads')) {
				mkdir(getcwd(). '/uploads', 0777);
			}

		    move_uploaded_file($_FILES['myfile']['tmp_name'],
		    getcwd(). '/uploads/'.$src_file_name);

		    //optimize image using TinyPNG
	    	$source = \Tinify\fromFile(getcwd(). '/uploads/'.$src_file_name);
			  $source->toFile(getcwd(). '/uploads/'.$src_file_name);
		    echo "File uploaded successfully <br>"; // IMAGE FILE UPLOADED ON TO THE SERVER

        list($width, $height) = getimagesize("uploads/" . $src_file_name);

        $categoryID = $_POST["upload-file-category-option"];

        // WRITE IMAGE INTO DATABASE
        $sql = "INSERT INTO images (name, width, height, category_id) VALUES ('$src_file_name', '$width', '$height', '$categoryID')";
        if ($db->query($sql) == TRUE) {
          echo "Succesfully written into DB. <br>"; // IMAGE INFO WRITTEN INTO DB
        } else {
          echo "<span style='color: red'>Error writing into DB.</span> <br>";

          if (file_exists($src_file_name)) {
            unlink($src_file_name);
            echo 'File '.$src_file_name.' has been deleted <br>';
          } else {
            echo '<span style="color: red">Could not delete '.$src_file_name.', file does not exist</span> <br>';
          }

        }
        mysqli_close($db);

		} else {
		    echo 'Invalid file format <br>';
		}
	}
}

if (array_key_exists('delete_file', $_POST)) {
  $filename = $_POST['delete_file'];
  echo "Deleting: " . explode("/", $filename)[1] . "\n\n. <br>";
  if (file_exists($filename)) {
    unlink($filename);

    $filename = explode("/", $filename)[1];

    // REMOVE FROM DB
    $query = "DELETE FROM images WHERE name='$filename'";
    $result = $db->query($query);
    if ($result == TRUE) {
      echo "Succesfully deleted image from DB. <br>";
    } else {
      echo "<span style='color: red'>Failed to delete image from DB.</span> <br>";
    }

    echo 'File '.$filename.' has been deleted <br>';
  } else {
    echo '<span style="color: red">Could not delete '.$filename.', file does not exist</span> <br>';
  }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Steling Website</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/administration_design.css">
    <link rel="stylesheet" href="css/footer_design.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
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
            </div>
        </div>
    </nav>

    <section id="header" class="py-5">
      <div class="container">
        <div class="row">
          <div class="col-sm">
            <h1>Administracijska Orodja</h1>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-sm">
            <p>Prijavljen <small><?php echo $_SESSION["email"]; ?></small></p>
          </div>
        </div>
      </div>
    </section>

    <hr>

    <section class="settings-section">
      <div class="container">
        <h3>Nastavitve</h3>

        <form action="administration.php" method="post">
          <h6>Izbriši kategorijo</h6>
          <select name="delete-category-option" class="nice-select category-select-dropdown"></select>
          <h6>Potrdi izbris kategorije</h6>
          <input class="btn btn-default" type="submit" name="submit-category-remove" value="Izbriši kategorijo">
        </form>

        <hr>

        <form action="administration.php" method="post">
          <h6>Dodaj kategorijo</h6>
          <input type="text" name="add-category-name" placeholder="Ime kategorije">
          <h6>Potrdi vnos kategorije</h6>
          <input class="btn btn-default" type="submit" name="submit-category-add" value="Dodaj kategorijo">
        </form>

      </div>
    </section>

    <div class="container">
      <hr>
    </div>

    <section class="file-upload-section">
      <div class="container">
        <h3>Nalaganje slik</h3>
        <form action="administration.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <h6>Izberi sliko</h6>
              <input type="file" name="myfile" value="InputImage">
              <h6>Izberi kategorijo</h6>
              <select name="upload-file-category-option" class="nice-select category-select-dropdown"></select>
            </div>
            <h6>Potrdi in naloži sliko</h6>
            <input class="submit-upload-file-btn btn btn-default" type="submit" name="submit-file-upload" value="Naloži">
        </form>
      </div>
    </section>

    <div class="container">
      <hr class="container">
    </div>

    <section id="uploaded-photos-section">
      <div class="container">
        <div class="row">
          <div class="col-sm">
            <h3>Slike</h3>
          </div>
        </div>
        <ul id="images-list" class="list-unstyled">
          <?php
          echo "<div class='hidetouser'>";
          require('php/GetCategories.php');
          require('php/GetImages.php');
          echo "</div>";

          for ($i=0; $i < count($imageNames); $i++) {
            echo '<li class="media">';
              echo '<img class="mr-3" src="uploads/'. $imageNames[$i] .'">';
              echo '<div class="media-body">';
                echo '<h5 class="mt-0 mt-1">' . $imageNames[$i] . '</h5>';
                echo 'Category: ' . CategoryIDToName($imageCategoryIDs[$i]);
                echo '<form method="post">';
                  echo '<input type="hidden" value="uploads/' . $imageNames[$i] . '" name="delete_file" />';
                  echo '<div class="text"><input type="submit" class="btn btn-danger" value="Zbriši Sliko" /></div>';
                echo '</form>';
              echo '</div>';
            echo '</li>';
          }
          function CategoryIDToName($catID) {
            global $categoryIDs;
            global $categoryNames;
            for ($i=0; $i < count($categoryIDs); $i++) {
              if ($categoryIDs[$i] == $catID) {
                return $categoryNames[$i];
              }
            }
          }
          ?>
        </ul>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/GetDropdownOptions.js" charset="utf-8"></script>
    <script src="js/jquery.js" charset="utf-8"></script>
    <script src="js/jquery.nice-select.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

    <script type="text/javascript">
    $(document).ready(function() {
      $(".hidetouser").remove();
    });
    </script>

  </body>
</html>
