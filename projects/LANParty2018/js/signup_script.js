class Player {
  constructor(fullname, school) {
    this.FullName = fullname;
    this.School = school;
    this.Email = null;
  }

  AddEmail(email) {
    this.Email = email;
  }
}

var TeamNameInput = $("input[name='teamname']");
var TeamTagInput = $("input[name='teamtag']");
var Players = [];

function ProcessSignup(el) {

  $(el).attr("disabled", true);
  $(el).addClass("signup-button-disabled");

  Players = [];
  ResetInputColors();
  if (!HasErrors()) {
    TryInsertTeam();
  }

  $(el).attr("disabled", false);
  $(el).removeClass("signup-button-disabled");
}

function TryInsertTeam() {

  $.ajax({
    type: "POST",
    data: {
      'teamname': TeamNameInput.val(),
      'teamtag': TeamTagInput.val(),
      'selectedgame': new URLSearchParams(window.location.search).get('selectedgame'),
      'players': JSON.stringify(Players)
    },
    url: "php/InsertTeam.php",
    success: function(data) {
      ProcessData(data);
    },
    error: function(data) {
      console.log("ERROR: " + data);
    }
  });

  function ProcessData(data) {
    console.log(data);
    $("html, body").animate({ scrollTop: 0 }, "slow");
    if (data == "SUCCESS_SIGNUP") {
      window.location.href = "signup.php?selectedgame=" + getUrlParameter('selectedgame') + "&signupSuccess";
    } else if (data == "ERR_SIGNUPS_FULL") {
      $("#error-alert p").text("Ni več možnih prijav!");
      $("#error-alert").css("display", "block");
    } else if (data == "ERR_INSERT_TEAM") {
      $("#error-alert p").text("Napaka pri prijavi ekipe! Preglejte Ime in Kratico!");
      $("#error-alert").css("display", "block");
    } else {
      $("#error-alert p").text('Neznana napaka: ' + data);
      $("#error-alert").css("display", "block");
    }
  }
}

function HasErrors() {

  var hasErrors = false;

  if (TeamNameInput.val().length > 50 || TeamNameInput.val().length <= 0) {
    TeamNameInput.addClass('input_error');
    hasErrors = true;
  }

  if (TeamTagInput.val().length > 4 || TeamTagInput.val().length <= 0) {
    TeamTagInput.addClass('input_error');
    hasErrors = true;
  }

  // ČEK PLEJRS
  for (var i = 1; i < 6; i++) {
    var FullNameInput = $("input[name='p" + i + "-fullname']");
    var SchoolInput =  $("input[name='p" + i + "-school']");
    var Email = null;

    if (FullNameInput.val().length > 150 || FullNameInput.val().length <= 0) {
      FullNameInput.addClass('input_error');
      hasErrors = true;
    }

    if (SchoolInput.val().length > 150 || SchoolInput.val().length <= 0) {
      SchoolInput.addClass('input_error');
      hasErrors = true;
    }

    var currentPlayer = new Player(FullNameInput.val(), SchoolInput.val());

    //# REMOVE IF ERROR
    currentPlayer.AddEmail(null);

    if (i == 1) {
      var EmailInput =  $("input[name='p" + i + "-email']");
      if (EmailInput.val().length > 150 || EmailInput.val().length <= 0) {
        EmailInput.addClass('input_error');
        hasErrors = true;
      }
      if (!validateEmail(EmailInput.val())) {
        EmailInput.addClass('input_error');
        hasErrors = true;
      }
      currentPlayer.AddEmail(EmailInput.val());
    }
    Players.push(currentPlayer);
  }

  if (hasErrors) {
    return true;
  } else {
    return false;
  }

}

function ResetInputColors() {
  TeamNameInput.removeClass('input_error');
  TeamTagInput.removeClass('input_error');
  $("input[name='p1-email']").removeClass('input_error');
  for (var i = 1; i < 6; i++) {
    $("input[name='p" + i + "-fullname']").removeClass('input_error');
    $("input[name='p" + i + "-gamecontact']").removeClass('input_error');
    $("input[name='p" + i + "-school']").removeClass('input_error');
  }
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
