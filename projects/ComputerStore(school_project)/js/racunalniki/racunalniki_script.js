$(document).ready(function() {

  assignClickFunctions();

  $('.tap-target').tapTarget('open');

  $(".racunalniki-collapsible-header").click(function() {
    CheckDodatkiCollapsileBody(true);
  });

  $(".dodatki-collapsible-header").click(function() {
    CheckDodatkiCollapsileBody(false);
  });

});

function assignClickFunctions() {
  $("#NamizniSistemi").click(function() {
    window.location.href = "namiznisistemi.html";
  });

  $("#PrenosniSistemi").click(function() {
    window.location.href = "prenosnisistemi.html";
  });

  $("#Strezniki").click(function() {
    window.location.href = "strezniki.html";
  });

  $("#Ohisja").click(function() {
    window.location.href = "ohisja.html";
  });

  $("#Ventilatorji").click(function() {
    window.location.href = "ventilatorji.html";
  });

  $("#MiskeInTipkovnice").click(function() {
    window.location.href = "miskeintipkovnice.html";
  });

  $("#Torbice").click(function() {
    window.location.href = "torbice.html";
  });

}

function CheckDodatkiCollapsileBody(inverted) {
  var item = $(".dodatki-collapsible-body");
  var result = inverted ? item.css("display") != "block" : item.css("display") !=
    "none";

  if (result) {

    if ($(".dodatki-icon").text() != "add") {
      $(".dodatki-icon").css("transform", "scaleX(0)");
      setTimeout(function() {
        $(".dodatki-icon").text("add");
      }, 300);

      setTimeout(function() {
        $(".dodatki-icon").css("transform", "scaleX(1)");
      }, 300);
    }

  } else {

    if ($(".dodatki-icon").text() != "false") {
      $(".dodatki-icon").css("transform", "scaleX(0)");
      setTimeout(function() {
        $(".dodatki-icon").text("remove");
      }, 300);
      setTimeout(function() {
        $(".dodatki-icon").css("transform", "scaleX(1)");
      }, 300);
    }
  }
}
