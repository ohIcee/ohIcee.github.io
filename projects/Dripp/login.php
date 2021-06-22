<?php

if (isset($_GET['login'])) {

  $Email = $_GET['emailinput'];
  $Password = $_GET['passwordinput'];
  require_once 'php/DBConnect.php';

  $sql = "SELECT ID, Active, Password FROM users WHERE Email=:email";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":email", $Email);
  $result = $stmt->execute();
  $row = $stmt->fetch();

  $CorrectPassword = $row['Password'];
  if (password_verify($Password, $CorrectPassword)) {
    if ($row['Active'] == 0) {
      echo "ERR_ACC_NOTCONFIRMED";
      //exit();
    } else {
      echo "SUCCESS_LOGIN";
      // $_SESSION["loggedUserID"] = $row['ID'];
    }
  } else {
    echo "ERR_INCORRECT";
    //exit();
  }

}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dripp. - Welcome</title>

    <link href="https://fonts.googleapis.com/css?family=Caveat|Patrick+Hand|Catamaran" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/custom_elements.css">
  </head>
  <body>

    <div class="row align-items-center" style="height: 100vh; max-height: 100%; max-width: 100%;">
      <div class="w-75" style="margin: 0 auto">
        <h2 class="text-center font-weight-semibold">
          <span id="title">Login to Dripp.</span>
        </h2>

        <div id="authenticate-section">
          <form>
            <div class="form-group">
              <label for="email-input">Email address</label>
              <input name="emailinput" value="<?=$Email?>" type="email" class="form-control" id="email-input" aria-describedby="emailHelp" placeholder="Enter email" required>
            </div>
            <div class="form-group">
              <label for="password-input">Password</label>
              <input name="passwordinput" type="password" class="form-control" id="password-input" placeholder="Password" required>
            </div>
          </div>

          <div id="auth-buttons">
            <button name="login" type="submit" class="btn btn-primary btn-lg btn-block">Login.</button>
            <p onclick="window.location.href='register.php'" class="text-center">Don't have an account? <a href="#">Register.</a></p>
          </div>
        </form>
      </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
