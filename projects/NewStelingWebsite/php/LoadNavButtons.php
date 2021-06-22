<?php

$Email = $_SESSION['email'];

if ($Email == null) {
  echo '<li class="nav-item"><a class="login-btn font-weight-light nav-link" data-toggle="modal" data-target="#LoginModal" href="#">Prijava</a></li>';
  echo '<li class="nav-item"><a class="register-btn font-weight-light nav-link" data-toggle="modal" data-target="#RegisterModal" href="#">Registracija</a></li>';
} else {
  echo '<li class="nav-item"><a class="font-weight-light nav-link" href="administration.php">Administracijska orodja</a></li>';
  echo '<li class="nav-item"><a class="font-weight-light nav-link" href="php/logout.php">Odjava</a></li>';
}

?>
