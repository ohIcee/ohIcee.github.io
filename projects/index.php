<style media="screen">
  * {
    font-family: Arial;
  }
  ul {
    list-style: none;
    margin: 0;
    padding: 0;
    border-left: 3px solid gray;
  }
  li {
    height: 30px;
    margin: 10px 0px;
    transition-duration: 0.3s;
  }
  li:hover {
    padding: 10px 0px;
    background-color: rgba(0, 0, 0, 0.1);
  }
  a {
    color: black;
    text-decoration: none;
    line-height: 30px;
    padding-left: 10px;
  }
</style>

<meta name="viewport" content="width=device-width, initial-scale=1">

<?php

if (isset($_POST["submit"])) {
  if($_POST["passwordInput"] == "jakagod") {
    $dirs = array_filter(glob('*'), 'is_dir');
    echo "<ul>";
    foreach ($dirs as $key => $value) {
      echo "<li><a href='" . $value . "'>" . $value . "</a></li>";
    }
    echo "</ul>";
  } else {
    WriteConfirm();
  }
} else {
  WriteConfirm();
}

function WriteConfirm() {
  echo '<form action="index.php" method="post">';
    echo '<label for="passwordinput">Please verify yourself to show folders<br></label>';
    echo '<input id="passwordinput" type="password" name="passwordInput" placeholder="Key">';
    echo '<button type="submit" name="submit">Confirm</button>';
  echo '</form>';
}

?>
