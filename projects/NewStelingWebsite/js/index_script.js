var indexImageNames = new Array();

$(document).ready(function() {

  AssignClickFunctions();

  $("#login-modal-error").hide();
  $("#register-modal-error").hide();

  $('#LoginModal').on('shown.bs.modal', function() {
    $('#login-email-input').trigger('focus');
  });

  $("#steling-logo").on("click", function() {
    $('html, body').animate({
      scrollTop: $("#opodjetju").offset().top
    }, 800);
  });

  $('a[href*="#"]').on('click', function(e) {
    e.preventDefault();

    $('html, body').animate({
      scrollTop: $($(this).attr('href')).offset().top
    }, 500, 'swing');
  });

  // Scroll spy
  $('body').scrollspy({
    target: "#main-nav"
  });
});

$(function() {
  var navMain = $(".navbar-collapse");
  navMain.on("click", "a:not([data-toggle])", null, function() {
    navMain.collapse('hide');
  });
});

function AssignClickFunctions() {
  $(".login-btn").on("click", function() {
    $('#login-email-input').val("");
    $('#login-password-input').val("");
    $("#login-modal-error").hide();
  });

  $(".register-btn").on("click", function() {
    $('#register-email-input').val("");
    $('#register-password-input').val("");
    $('#register-confirm-password-input').val("");
    $("#register-modal-error").hide();
  });

  $("#login-submit-button").on("click", function() {
    CheckLogin();
  });

  $("#register-submit-button").on("click", function() {
    CheckRegister();
  });
}

function CheckLogin() {
  var EmailInput = $("#login-email-input").val();
  var PasswordInput = $("#login-password-input").val();

  $.ajax({
    type: 'POST',
    url: 'php/Authenticate.php',
    data: {
      EmailInput: EmailInput,
      PasswordInput: PasswordInput,
      ConfirmPasswordInput: null,
      AuthenticateType: "login",
    },
    success: function(response) {
      if (response == 'SUCCESS_LOGIN') {
        window.location.href = "index.php"
      } else {
        ShowError(response, true);
      }
    }
  });

}

function CheckRegister() {
  var EmailInput = $("#register-email-input").val();
  var PasswordInput = $("#register-password-input").val();
  var ConfirmPasswordInput = $("#register-confirm-password-input").val();

  $.ajax({
    type: 'POST',
    url: 'php/Authenticate.php',
    data: {
      EmailInput: EmailInput,
      PasswordInput: PasswordInput,
      ConfirmPasswordInput: ConfirmPasswordInput,
      AuthenticateType: "register",
    },
    success: function(response) {
      if (response == 'SUCCESS_REGISTER') {
        alert("Success");
      } else {
        ShowError(response, false);
      }
    }
  });
}

function ShowError(error, isLogin) {

  if (isLogin) {

    switch (error) { // LOGIN ERRORS
      case "ERR_NULL_email":
        $("#login-modal-error").text("Prosimo, preverite polja!");
        break;
      case "ERR_NULL_password":
        $("#login-modal-error").text("Prosimo, preverite polja!");
        break;
      case "ERR_WRONGINFORMATION":
        $("#login-modal-error").text(
          "Nepravilna prijava! Prosimo preverite polja.");
        break;
      case "ERR_NOTAPPROVEDBYADMIN":
        $("#login-modal-error").text(
          "Račun ni odobren od administratorja, če menite, da je to napaka kontaktirajte administratorja!"
        );
        break;
    }
    $("#login-modal-error").slideDown();
  } else { // REGISTER ERRORS
    switch (error) {
      case "ERR_NULL_email":
        $("#register-modal-error").text("Prosimo, preverite polja!");
        break;
      case "ERR_NULL_password":
        $("#register-modal-error").text("Prosimo, preverite polja!");
        break;
      case "ERR_NULL_confirmpassword":
        $("#register-modal-error").text("Prosimo, preverite polja!");
        break;
      case "ERR_DUPLICATE_email":
        $("#register-modal-error").text("Ta račun že obstaja!");
        break;
      case "ERR_INVALID_email":
        $("#register-modal-error").text("Nepravilna oblika emaila!");
        break;
      case "ERR_INSERT":
        $("#register-modal-error").text(
          "Napak pri zapisovanju v podatkovno bazo. Prosimo kontaktirajte administratorja!"
        );
        break;
    }
    $("#register-modal-error").slideDown();
  }
}

function ToggleShowPassword() {
  var passwordinput = $("#register-password-input").attr('type');
  var confirmpasswordinput = $("#register-confirm-password-input").attr('type');
  if (passwordinput === "password") {
    $("#register-password-input").attr("type", "text");
    $("#register-confirm-password-input").attr("type", "text");
  } else {
    $("#register-password-input").attr("type", "password");
    $("#register-confirm-password-input").attr("type", "password");
  }
}
