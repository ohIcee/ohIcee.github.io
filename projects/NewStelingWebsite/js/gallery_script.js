var imageCategoryIDs = new Array();
var imageNames = new Array();

var imageCategoryNames = new Array();

var grid;

function GetImages() {
  $.ajax({
    url: "php/GetImages.php",
    success: function(result) {
      var imageRows = result.split(' ');
      for (var i = 0; i < imageRows.length - 1; i++) {
        var imageRow = imageRows[i].split('/');
        imageCategoryIDs.push(imageRow[0]);
        imageNames.push(imageRow[1]);
      }
      var categoryID = $(".tempCatName").text();
      $(".tempCatName").remove();
      var categoryName = GetCategoryNameFromID(categoryID);
      $('select').val(categoryID).niceSelect('update');
      FillImageGrid(categoryName);
    }
  });
}

function FillImageGrid(category) {
  grid = document.querySelector('#grid');
  for (var i = 0; i < imageNames.length; i++) {
    if (category != "Vse") {
      if (GetCategoryNameFromID(imageCategoryIDs[i]) == category) {
        AddImg();
      }
    } else {
      AddImg();
    }
  }

  function AddImg() {
    var item = document.createElement('img');
    var h = '<img src=uploads/' + imageNames[i] + '>';
    salvattore['append_elements'](grid, [item]);
    item.outerHTML = h;
  }

}

function GetCategoryNameFromID(CategoryID) {
  for (var i = 0; i < categoryIDs.length; i++) {
    if (categoryIDs[i] == CategoryID) {
      return categoryNames[i];
    }
  }
  return "null";
}
