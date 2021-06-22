<?php

require_once 'DBConnect.php';

if (isset($_POST['ajaxCommand'])) {
  if ($_POST['ajaxCommand'] == 'GetNoviceNaslovi') {
    echo json_encode(GetNoviceNaslovi());
  }
  if ($_POST['ajaxCommand'] == 'GetReferenceNaslovi') {
    echo json_encode(GetReferenceNaslovi());
  }
  if ($_POST['ajaxCommand'] == 'IzbrisiNovico') {
    echo IzbrisiNovico();
  }
  if ($_POST['ajaxCommand'] == 'IzbrisiReferenco') {
    echo IzbrisiReferenco();
  }
}

function GetReferenceNaslovi() {
  global $db;

  $sql = "SELECT ID, naslov FROM reference";
  $stmt = $db->prepare($sql);
  $result = $stmt->execute();
  $rows = $stmt->fetchAll();
  return $rows;
}

function IzbrisiReferenco() {
  global $db;

  $sql = "SELECT slika FROM referenca_slike WHERE referenca_ID = :id";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':id', $_POST['id']);
  $result = $stmt->execute();
  $rows = $stmt->fetchAll();

  if ($result) {
    $sql = "DELETE FROM referenca_slike WHERE referenca_ID = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $_POST['id']);
    $stmt->execute();

    $sql = "DELETE FROM reference WHERE ID=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $_POST['id']);
    $result = $stmt->execute();

    foreach ($rows as $key => $value) {
      unlink('../uploads/reference/' . $value['slika']);
    }
  }

  return $result;
}

function IzbrisiNovico() {
  global $db;

  // SELECT IMAGE NAME
	$sql = "SELECT slika FROM novice WHERE ID=:id";
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':id', $_POST['id']);
	$result = $stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

  echo "slika: " . $row["slika"];

	if ($result) {
		// REMOVE FROM DB
		$sql = "DELETE FROM novice WHERE ID=:id";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $_POST['id']);
		$result = $stmt->execute();

		// REMOVE FROM SERVER
		if ($result) {
			unlink('../uploads/novice/' . $row['slika']);
		}
	}
}

function GetNoviceNaslovi() {
  global $db;

  $sql = "SELECT ID, naslov FROM novice";
  $stmt = $db->prepare($sql);
  $result = $stmt->execute();
  $rows = $stmt->fetchAll();
  return $rows;
}



function CompressImage($source, $destination, $quality) {

	$info = getimagesize($source);

	if ($info['mime'] == 'image/jpeg')
		$image = imagecreatefromjpeg($source);

	elseif ($info['mime'] == 'image/gif')
		$image = imagecreatefromgif($source);

	elseif ($info['mime'] == 'image/png')
		$image = imagecreatefrompng($source);

	imagejpeg($image, $destination, $quality);

	return $destination;
}

function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}

?>
