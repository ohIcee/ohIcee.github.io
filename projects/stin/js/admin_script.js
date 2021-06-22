$(document).ready(function() {
  $('#izbrani-datum').val(new Date().toDateInputValue());
  $('#izbrani-datum2').val(new Date().toDateInputValue());
  $("#remove-novica-btn").click(function() {
    IzbrisiNovico();
  });
  $("#remove-referenca-btn").click(function() {
    IzbrisiReferenco();
  });

  GetNovice();
  GetReference();
});

var currentIzbrisiNovicaID = -1;
var currentIbrisiReferencoID = -1;

function GetReference() {

  $.ajax({
    url: 'php/HelperFunctions.php',
    type: 'POST',
    data: {
      ajaxCommand: 'GetReferenceNaslovi',
    },
    success: function(data) {
      data = JSON.parse(data);

      var referenceVals = [];
      data.forEach(function(el) {
        referenceVals.push( {name: el['naslov'], value: el['ID']}, );
      });

      $('#reference-dropdown').dropdown({
        values: referenceVals,
        onChange: function(value, text, $selectedItem) {
          currentIbrisiReferencoID = value;
        }
      });

    }
  });
}

function hide(val) {
  if (val == 'novica-remove') {
    $("#novica-remove-success").hide();
  }
  if (val == 'referenca-remove') {
    $("#referenca-remove-success").hide();
  }
}

function IzbrisiReferenco() {

  if (currentIbrisiReferencoID == -1) { return; }

  $("#remove-referenca-btn").addClass("loading");

  $.ajax({
    url: 'php/HelperFunctions.php',
    type: 'POST',
    data: {
      ajaxCommand: 'IzbrisiReferenco',
      id: currentIbrisiReferencoID
    },
    success: function(data) {
      $("#remove-referenca-btn").removeClass("loading");

      if (data) {
        $("#referenca-remove-success").show();
        GetReference();
      }
    }
  });

}

function GetNovice() {

  $.ajax({
    url: 'php/HelperFunctions.php',
    type: 'POST',
    data: {
      ajaxCommand: 'GetNoviceNaslovi',
    },
    success: function(data) {
      data = JSON.parse(data);

      var noviceVals = [];
      data.forEach(function(el) {
        noviceVals.push( {name: el['naslov'], value: el['ID']}, );
      });

      $('#novice-dropdown').dropdown({
        values: noviceVals,
        onChange: function(value, text, $selectedItem) {
          currentIzbrisiNovicaID = value;
        }
      });

    }
  });
}

function IzbrisiNovico() {

  if (currentIzbrisiNovicaID == -1) { return; }

  $("#remove-novica-btn").addClass("loading");

  $.ajax({
    url: 'php/HelperFunctions.php',
    type: 'POST',
    data: {
      ajaxCommand: 'IzbrisiNovico',
      id: currentIzbrisiNovicaID
    },
    success: function(data) {
      console.log(data);
      $("#remove-novica-btn").removeClass("loading");

      if (data) {
        $("#novica-remove-success").show();
        GetNovice();
      }
    }
  });

}

Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
