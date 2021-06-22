function Login() {

  var emailVal = $("#email-input").val();
  var passVal = $("#password-input").val();

  $("#email-input").removeClass("input-err");
  $("#password-input").removeClass("input-err");

  $.ajax({
    url: 'php/Login.php',
    type: 'POST',
    data: {
      email: emailVal,
      pass: passVal
    },
    success: function(data) {
      console.log(data);
      ProcessData(data);
    }
  });

  function ProcessData(data) {

    switch(data) {
      case "ERR_LEN_EMAIL":
        $("#email-input").addClass("input-err");
        break;
      case "ERR_LEN_PASS":
        $("#password-input").addClass("input-err");
        break;
      case "ERR_INVALID_EMAIL":
        $("#email-input").addClass("input-err");
        break;
      case "ERR_DB":
        break;
      case "ERR_INVALID_LOGIN":
        $("#email-input").addClass("input-err");
        $("#password-input").addClass("input-err");
        break;
      case "SUCCES_LOGIN":
        alert("Succ");
        break;
    }

  }

}
