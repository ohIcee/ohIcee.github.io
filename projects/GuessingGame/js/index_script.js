var amountOfTries = 0;
var currentGuessTimeSeconds = 0;

var counterInterval;

function ToggleCounter(start) {
  if (start) {
    // Start Counter
    counterInterval = setInterval(IncrementCounter, 1000);
  } else {
    // Stop Counter
    clearInterval(counterInterval);
  }
}

function IncrementCounter() {
  currentGuessTimeSeconds += 1;
}

function StartGame() {
  document.getElementById('pregame-wrapper').style.display = "none";
  document.getElementById('game-wrapper').style.display = "block";

  ToggleCounter(true);
}

function TryGuess() {

  document.getElementById('guess-button').classList.add("loading");
  document.getElementById('guess-button').disabled = true;

  var CurrentGuess = document.getElementById('guess-input').value;

  $.ajax({
    type: "GET",
    url: "php/RandomNumber.php",
    success: function(data) {

      // Convert to int zato ker je JS avtizem
      CurrentGuess = parseInt(CurrentGuess);
      data = parseInt(data);

      if (CurrentGuess == data) {
        EndGame();
      } else {
        DisplayWrongGuess(data);
      }

      document.getElementById('guess-button').classList.remove("loading");
      document.getElementById('guess-button').disabled = false;
    }
  });

  function DisplayWrongGuess(data) {
    document.getElementById('wrong-answer-message-feedback').innerHTML =
    CurrentGuess > data
    ? "big"
    : "small";
    document.getElementById('wrong-answer-message').style.display = "block";
    amountOfTries++;
  }

}

function EndGame() {
  document.getElementById('game-wrapper').style.display = "none";
  document.getElementById('tries').innerHTML = amountOfTries + " Tries";
  document.getElementById('time').innerHTML = sec2time(currentGuessTimeSeconds);
  document.getElementById('endgame-wrapper').style.display = "block";

  ToggleCounter(false);
}

function SubmitResult() {

  document.getElementById('submit-result-button').classList.add("loading");

  var tries = amountOfTries;
  var time = sec2time(currentGuessTimeSeconds);
  var name = document.getElementById('endgame-name-input').value;

  $.ajax({
    type: "POST",
    url: "php/UploadResult.php",
    data: {
      AmountOfTries: tries,
      GuessTime: time,
      Name: name
    },
    success: function(data) {
      console.log(data);
      location.reload();
    }
  });

}

function sec2time(timeInSeconds) {
    var pad = function(num, size) { return ('000' + num).slice(size * -1); },
    time = parseFloat(timeInSeconds).toFixed(3),
    hours = Math.floor(time / 60 / 60),
    minutes = Math.floor(time / 60) % 60,
    seconds = Math.floor(time - minutes * 60),
    milliseconds = time.slice(-3);

    return pad(hours, 2) + ':' + pad(minutes, 2) + ':' + pad(seconds, 2);
}
