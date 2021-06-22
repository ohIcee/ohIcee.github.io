<?php
if (isset($_GET['register'])) {

  $Username = $_GET['usernameinput'];
  $Email = $_GET['emailinput'];
  $Password = $_GET['passwordinput'];
  $ConfirmPassword = $_GET['confirmpasswordinput'];
  $Gender = $_GET['genderselect'];

  require_once 'php/DBConnect.php';

  // DUPLICATE CHECK THEN INSERT
  $sql = "SELECT COUNT(Username) as usrnum, COUNT(Email) as emailnum FROM users WHERE Email = :email";
  $stmt = $db->prepare($sql);

  $stmt->bindvalue(':email', $Email);
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($Password == $ConfirmPassword) {
    if ($row['usrnum'] <= 0) {
      if ($row['emailnum'] <= 0) {

        $passwordHash = password_hash($Password, PASSWORD_BCRYPT, array("cost" => 12));

        $sql = "INSERT INTO users (Username, FirstName, LastName, Email, Password, Gender) VALUES (:username, :firstname, :lastname, :email, :password, :gender)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':firstname', $FirstName);
        $stmt->bindValue(':lastname', $LastName);
        $stmt->bindValue(':username', $Username);
        $stmt->bindValue(':email', $Email);
        $stmt->bindValue(':password', $passwordHash);
        $stmt->bindValue(':gender', $Gender);

        $result = $stmt->execute();

        if ($result) {
          echo "SUCCESS";
          header("Location: register.php?success");
        } else {
          echo "ERR_INSERT";
        }

      } else {
        echo 'ERR_DuplicateEmail';
      }
    } else {
      echo 'ERR_DuplicateUsername';
    }
  } else {
    echo "ERR_PasswordNotMatch";
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
        <h2 class="text-center font-weight-semibold mb-5">
          <span id="title">Register to <span class="font-weight-bold" style="font-family:'Caveat'; color: #5d3e32;">Dripp.</span></span>
        </h2>

        <div id="authenticate-section">
          <form>
            <div class="form-group">
              <label for="username-input">Username</label>
              <input name="usernameinput" value="<?=$Username?>" type="text" class="form-control" id="username-input" placeholder="Username" required>
            </div>
            <div class="form-group">
              <label for="email-input">Email address</label>
              <input name="emailinput" value="<?=$Email?>" type="email" class="form-control" id="email-input" aria-describedby="emailHelp" placeholder="Enter email" required>
            </div>
            <div class="form-group">
              <label for="password-input">Password</label>
              <input name="passwordinput" value="<?=$Password?>" type="password" class="form-control" id="password-input" placeholder="Password" required>
            </div>
            <div class="form-group">
              <label for="confirm-password-input">Confirm Password</label>
              <input name="confirmpasswordinput" value="<?=$ConfirmPassword?>" type="password" class="form-control" id="confirm-password-input" placeholder="Confirm Password" required>
            </div>
            <div class="form-group">
              <label for="gender-input">Gender</label>
              <select class="form-control" name="genderselect">
                <option value="0">Male</option>
                <option value="1">Female</option>
              </select>
            </div>
          </div>

          <div id="auth-buttons">
            <button name="register" type="submit" class="btn btn-primary btn-lg btn-block">Register.</button>
            <p onclick="window.location.href='login.php'" class="text-center">Already have an account? <a href="#">Login.</a></p>
          </div>
        </form>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="js/register.js" charset="utf-8"></script>
  </body>
</html>
-->
