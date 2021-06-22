var categoryIDs = new Array();
var categoryNames = new Array();
var current_site;


$(document).ready(function() {
  $('select').niceSelect();
  current_site = window.location.pathname.split("/").pop();
  GetCategories();
});

function GetCategories() {
  $.ajax({
    url: "php/GetCategories.php",
    success: function(result) {
      var categoryRows = result.split(' ');
      for (var i = 0; i < categoryRows.length - 1; i++) {
        var categoryRow = categoryRows[i].split('/');
        categoryIDs.push(categoryRow[0]);
        categoryNames.push(categoryRow[1]);
      }
      if (current_site == "gallery.php") {
        GetImages();
      }
      FillDropdowns();
    }
  });
}

function FillDropdowns() {
  for (var i = 0; i < categoryNames.length; i++) {

    if (current_site != "gallery.php" && categoryNames[i] == "Vse") {
      continue;
    }

    $(".category-select-dropdown").append("<option value=" + categoryIDs[i] +
      ">" +
      categoryNames[i] + "</option>");
  }

  $('select').niceSelect('update');

}
