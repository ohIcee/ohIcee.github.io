$(document).ready(function() {

  assignClickFunctions();

  $(".komponente-collapsible-header").click(function() {
    CheckDodatkiCollapsileBody(true);
  });

  $(".dodatki-collapsible-header").click(function() {
    CheckDodatkiCollapsileBody(false);
  });

});

function assignClickFunctions() {

  $("#Procesorji").click(function() {
    window.location.href = "procesorji.html";
  });

  $("#PomnilniskeEnote").click(function() {
    window.location.href = "Komponente/gskill.html";
  });

  $("#GraficneKartice").click(function() {
    window.location.href = "Komponente/GTX1080Ti.html";
  });

  $("#SSDDiski").click(function() {
    window.location.href = "Komponente/samsungssd.html";
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
