<?php

$email = $_POST['email'];
$password = $_POST['pass'];

if (strlen($email) <= 0 || strlen($email) > 75) {
  echo "ERR_LEN_EMAIL";
  exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo "ERR_INVALID_EMAIL";
  exit();
}

if (strlen($password) <= 0) {
  echo "ERR_LEN_PASS";
  exit();
}

require_once('DBConnect.php');

$sql = "SELECT password FROM users WHERE email=:email";
$stmt = $db->prepare($sql);
$stmt->bindValue(':email', $email);
$result = $stmt->execute();
$row = $stmt->fetch();

if (!$result) {
    echo "ERR_DB";
    exit();
}

if (!password_verify($row['password'], $password)) {
  echo "ERR_INVALID_LOGIN";
  exit();
}

echo "SUCCESS_LOGIN";

?>
