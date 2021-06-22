<?php
session_start();
require('DBConnect.php');

$EmailInput = $_POST["EmailInput"];
$PasswordInput = $_POST["PasswordInput"];
$ConfirmPasswordInput = $_POST["ConfirmPasswordInput"];
$AuthenticateType = $_POST["AuthenticateType"];

$HasError = false;

CheckErrors();

if ($HasError) {
  exit();
}

if ($ConfirmPasswordInput == null) {
  Login();
} else {
  Register();
}

function Login() {

  global $EmailInput, $db, $PasswordInput;

  $Email = filter_var($EmailInput, FILTER_SANITIZE_EMAIL);

  $query = "SELECT * FROM users WHERE email='$Email'";
  $result = $db->query($query);
  if ($result->num_rows === 1) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if (password_verify($PasswordInput, $row['password'])) {
      if ($row['approvedbyadmin'] == 1) {
        echo "SUCCESS_LOGIN";
        $_SESSION['email'] = strtolower($Email);
      } else {
        echo "ERR_NOTAPPROVEDBYADMIN";
      }
    } else {
      //echo "ERR_WRONGINFORMATION_pass";
    }
  } else if ($result->num_rows === 0 || $result->num_rows === null) {
    echo "ERR_WRONGINFORMATION";
  }
}

function Register() {

  global $PasswordInput, $db, $EmailInput;

  $HashedPassword = password_hash($PasswordInput, PASSWORD_DEFAULT);
  $num = mysqli_num_rows(mysqli_query($db, "SELECT * FROM users WHERE ( `email` = '".$EmailInput."' )"));
  if ($num > 0) {
    echo "ERR_DUPLICATE_email";
    return;
  }

  $Email = filter_var($EmailInput, FILTER_SANITIZE_EMAIL);
  if (filter_var($Email, FILTER_VALIDATE_EMAIL) === false) {
    echo "ERR_INVALID_email";
    return;
  }

  $sql = "INSERT INTO users (email, password) VALUES ('$Email', '$HashedPassword')";

  if ($db->query($sql) == TRUE) {
    echo "SUCCESS_REGISTER";
  } else {
    echo "ERR_INSERT";
  }

}

function CheckErrors() {

  global $EmailInput, $PasswordInput, $AuthenticateType, $ConfirmPasswordInput, $HasError;

  if (strlen($EmailInput) <= 0) {
    echo "ERR_NULL_email";
    $HasError = true;
    return;
  }

  if (strlen($PasswordInput) <= 0) {
    ECHO "ERR_NULL_password";
    $HasError = true;
    return;
  }
  if ($AuthenticateType == "register") {
    if (strlen($ConfirmPasswordInput) <= 0) {
      echo "ERR_NULL_confirmpassword";
      $HasError = true;
      return;
    }
  }
}

mysqli_close($db);

?>
