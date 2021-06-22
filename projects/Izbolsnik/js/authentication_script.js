// TODO:
// - ERROR/SUCCESS RESPONSE



$(document).ready(function() {
  $('#login-submit').click(function() {
    Authenticate("login");
  });
  $('#register-submit').click(function() {
    Authenticate("register");
  });
});

function Authenticate(authType) {

  ToggleAuthenticationLoader(true);

  var loginUsernameInput = $('#login-username-input').val();
  var registerUsernameInput = $('#register-username-input').val();
  var loginPasswordInput = $('#login-password-input').val();
  var registerPasswordInput = $('#register-password-input').val();
  var registerConfirmPasswordInput = $('#register-confirm-password-input').val();
  var registerEmailInput = $('#register-email-input').val();

  $.ajax({
    type: 'POST',
    url: 'php/authenticate.php',
    data: {
      loginUsername: loginUsernameInput,
      loginPassword: loginPasswordInput,
      registerUsername: registerUsernameInput,
      registerPassword: registerPasswordInput,
      registerConfirmPassword: registerConfirmPasswordInput,
      registerEmail: registerEmailInput,
      authType: authType
    },
    success: function(data) {
      if (data == "SUCCESS") {
        if (authType == "register") {
          window.location.replace("index.php?register");
        } else {
          window.location.replace("index.php?login");
        }
      } else {
        ShowAuthenticationError(data, authType);
      }
    }
  });

  setTimeout(function () {
    ToggleAuthenticationLoader(false);
  }, 1000);


}

$(document).keypress(function(e) {
  if (e.which == 13) {
    if (
      $('#login-username-input').is(':focus') ||
      $('#login-password-input').is(':focus')
    ) {
      Authenticate("login");
    }
    if (
      $('#register-username-input').is(':focus') ||
      $('#register-email-input').is(':focus') ||
      $('#register-password-input').is(':focus') ||
      $('#register-confirm-password-input').is(':focus')
    ) {
      Authenticate("register");
    }
  }
});
