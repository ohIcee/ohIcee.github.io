<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ( session_status() == 2 ) {
  echo "destroyed session";
  session_destroy();
}

session_start();
$_SESSION["NumberToGuess"] = rand(1, 150);

$user = 'root';
$pass = 'IEtAElB0Xe3g9Pe0';
$db = new PDO( 'mysql:host=localhost;dbname=NIRSA_GuessingGame', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Guessing Game</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/semantic.min.css">
    <link rel="stylesheet" href="css/index_design.css?v=1.2">
  </head>
  <body>

    <div id="site-wrapper">
      <div class="ui container">

        <div class="ui stackable grid">
          <div class="eight wide column">
            <div id="pregame-wrapper">
              <h1 id="game-name">Guessing Game</h1>
              <button onclick="StartGame()" class="ui violet button" type="button" name="button" id="play-button">Play</button>
            </div>

            <div id="game-wrapper">
              <p id="guess-input-label">Enter your guess</p>
              <div class="ui action input">
                <input id="guess-input" type="number" placeholder="0" required>
                <button id="guess-button" onclick="TryGuess()" class="ui button">Guess!</button>
              </div>

              <div class="ui negative message" id="wrong-answer-message">
                <div class="header">
                  The number you entered is too <span id="wrong-answer-message-feedback">YEET</span>
                </div>
                <p>Please try again
              </p></div>
            </div>

            <div id="endgame-wrapper">
              <h1>You guessed correctly!</h1>
              <p id="name-input-label">Enter your name</p>
              <div class="ui input fluid">
                <input id="endgame-name-input" type="text" placeholder="Search..." required>
              </div>

              <p id="time">00:00:00</p>
              <p id="tries">X Tries</p>

              <button id="submit-result-button" onclick="SubmitResult()" class="ui violet button" type="button" name="button" id="play-button">Submit</button>

            </div>
          </div>
          <div class="eight wide column">
            <div id="leaderboard-wrapper">
              <h3>Leaderboard</h3>
              <table class="ui table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Guesses</th>
                    <th>Time</th>
                  </tr>
                </thead>
                <tbody>

                  <?php

                  $sql = "SELECT * FROM results";
                  $query = $db->prepare($sql);
                  $query->execute();
                  $result = $query->fetchAll();

                  foreach ($result as $row) {
                    echo ""
                    . "<tr>"
                      . "<td>" . $row['Name'] . "</td>"
                      . "<td>" . $row['Tries'] . "</td>"
                      . "<td>" . $row['GuessTime'] . "</td>"
                    . "</tr>";
                  }

                  ?>
                </tbody>
                <tfoot class="full-width">
                  <tr>
                    <th colspan="4">
                      <div class="fluid ui small violet button disabled">
                        Loaded all
                      </div>
                    </th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/semantic.min.js" charset="utf-8"></script>
    <script src="js/index_script.js?v=1.0" charset="utf-8"></script>
  </body>
</html>
