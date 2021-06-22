<?php

//require_once 'DBConnect.php';

$user = 'root';
$pass = 'IEtAElB0Xe3g9Pe0';
$db = new PDO( 'mysql:host=localhost;dbname=izbolsnik', $user, $pass );

$errors = array();

$loginUsername = $_POST['loginUsername'];
$loginPassword = $_POST['loginPassword'];
$registerUsername = $_POST['registerUsername'];
$registerPassword = $_POST['registerPassword'];
$registerConfirmPassword = $_POST['registerConfirmPassword'];
$registerEmail = $_POST['registerEmail'];
$authType = $_POST['authType'];

ErrorCheck();
if (count($errors) > 0) {
  $errString = "";
  for ($i=0; $i < count($errors); $i++) {
    $errString .= $errors[$i];
    if ($i + 1 != count($errors)) {
      $errString .= '-';
    }
  }
  echo $errString;
  return;
}

if ($authType == "register") {
  Register();
} else {
  Login();
}

function Register() {

  global $registerUsername,
  $registerPassword,
  $registerEmail,
  $db;

  $sql = "SELECT COUNT(username) AS usrnum FROM users WHERE username = :username";
  $stmt = $db->prepare($sql);

  $stmt->bindvalue(':username', $registerUsername);
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($row['usrnum'] > 0) {
    die('ERR_DUPLICATE_USR');
  }

  $sql = "SELECT COUNT(email) AS emailnum FROM users WHERE email = :email";
  $stmt = $db->prepare($sql);

  $stmt->bindvalue(':email', $registerEmail);
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($row['emailnum'] > 0) {
    die('ERR_DUPLICATE_EMAIL');
  }

  $passwordHash = password_hash($registerPassword, PASSWORD_BCRYPT, array("cost" => 12));

  $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";

  $stmt = $db->prepare($sql);

  $stmt->bindValue(':username', $registerUsername);
  $stmt->bindValue(':email', $registerEmail);
  $stmt->bindValue(':password', $passwordHash);

  $result = $stmt->execute();

  if ($result) {
    echo "SUCCESS";
  } else {
    echo "ERR_INSERT";
  }
}

function Login() {
  global $loginPassword,
  $loginUsername,
  $db;

  $sql = "SELECT ID, username, password, email FROM users WHERE username = :username";
  $stmt = $db->prepare($sql);

  $stmt->bindValue(':username', $loginUsername);

  $stmt->execute();

  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user === false) {
    die('ERR_INVALID_INFO');
    return;
  }

  $validPassword = password_verify($loginPassword, $user['password']);

  if ($validPassword === false) {
    die('ERR_INVALID_INFO');
    return;
  }

  session_start();

  $_SESSION['user_id'] = $user['ID'];
  $_SESSION['user_username'] = $user['username'];
  $_SESSION['logged_in'] = time();

  echo "SUCCESS";

  exit;
}

function ErrorCheck() {

  global $errors,
  $loginUsername,
  $loginPassword,
  $registerUsername,
  $registerPassword,
  $registerConfirmPassword,
  $registerEmail,
  $authType;

  if ($authType == "login") {
    if (strlen($loginUsername) == 0) {
      array_push($errors, "ERR_NULL_LOGINUSERNAME");
    }
    if (strlen($loginPassword) == 0) {
      array_push($errors, "ERR_NULL_LOGINPASSWORD");
    }
  }

  if ($authType == "register") {
    if (strlen($registerUsername) == 0) {
      array_push($errors, "ERR_NULL_REGISTERUSERNAME");
    }
    if (strlen($registerPassword) == 0) {
      array_push($errors, "ERR_NULL_REGISTERPASSWORD");
    }
    if (strlen($registerConfirmPassword) == 0) {
      array_push($errors, "ERR_NULL_REGISTERCONFIRMPASSWORD");
    }
    if (strlen($registerEmail) == 0) {
      array_push($errors, "ERR_NULL_REGISTEREMAIL");
    }
    if ($registerPassword != $registerConfirmPassword) {
      array_push($errors, "ERR_DIFFERENT_REGISTERPASSWORDS");
    }
    $registerEmail = filter_var($registerEmail, FILTER_SANITIZE_EMAIL);
    if (!filter_var($registerEmail, FILTER_VALIDATE_EMAIL)) {
      array_push($errors, "ERR_INVALID_REGISTEREMAIL");
    }
  }

}

?>
