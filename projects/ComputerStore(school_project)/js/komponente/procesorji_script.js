$(document).ready(function() {
  $('.materialboxed').materialbox();

  assignClickFunctions();

});

function assignClickFunctions() {

  $("#Intel8700").click(function() {
    window.location.href = "Komponente/intel8700.html";
  });

  $("#Intel8400").click(function() {
    window.location.href = "Komponente/intel8400.html";
  });

  $("#Ryzen1800x").click(function() {
    window.location.href = "Komponente/ryzen1800x.html";
  });

}
