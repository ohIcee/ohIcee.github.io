$(document).ready(function() {
  $('.materialboxed').materialbox();

  assignClickFunctions();

});

function assignClickFunctions() {

  $("#MacbookAir").click(function() {
    window.location.href = "PrenosniSistemi/macbookair.html";
  });

  $("#RazerBladePro").click(function() {
    window.location.href = "PrenosniSistemi/razerbladepro.html";
  });

  $("#HPSpectreX360").click(function() {
    window.location.href = "PrenosniSistemi/hpspectrex360.html";
  });

  $("#GooglePixelbook").click(function() {
    window.location.href = "PrenosniSistemi/pixelbook.html";
  });

  $("#MiAir").click(function() {
    window.location.href = "PrenosniSistemi/xiaominotebookair.html";
  });

  $("#DellXPS15").click(function() {
    window.location.href = "PrenosniSistemi/dellxps15.html";
  });

}
