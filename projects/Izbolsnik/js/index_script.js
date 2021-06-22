var origin_location;
var destination_location;
var switched_origin_location;
var switched_destination_location;
var relation_date;
var switch_relations;
var selected_weekday = "normal";
var current_theme = "light";
var stations = new Array();
var departureTimes = new Array();
var arrivalTimes = new Array();
var travelTimes = new Array();
var travelCost = 0;
var updateRelationsOnInputEnter = false;

$(window).scroll(function() {
  if ($(document).scrollTop() > 35) {
    if ($('#header-wrapper').data('size') == 'big') {
      $('#header-wrapper').data('size', 'small');
      $('#header-wrapper').stop().animate({
        height: '40px'
      }, 200);
      $('#header-name').css("line-height", "40px");
      $('#header-name').css("font-size", "30px");
      $('#theme-wrapper i').css("line-height", "40px");
      $('#theme-wrapper i').css("font-size", "30px");
    }
  } else {
    if ($('#header-wrapper').data('size') == 'small') {
      $('#header-wrapper').data('size', 'big');
      $('#header-wrapper').stop().animate({
        height: '70px'
      }, 200);
      $('#header-name').css("line-height", "70px");
      $('#header-name').css("font-size", "40px");
      $('#theme-wrapper i').css("line-height", "70px");
      $('#theme-wrapper i').css("font-size", "40px");
    }
  }
});

$(document).ready(function() {
  ProcessQueryParams();
  AssignClickFunctions();
  SetupWebsite();
});

function ToggleSideBar(type) {
  if (type == 'show') {
    $('.sidebar').sidebar('show');
  } else if (type == 'hide') {
    $('.sidebar').sidebar('hide');
  } else if (type == 'toggle') {
    $('.sidebar').sidebar('toggle');
  }
}

function ClearInputFields() {
  $('#login-username-input').val('');
  $('#login-password-input').val('');
  $('#register-username-input').val('');
  $('#register-email-input').val('');
  $('#register-password-input').val('');
  $('#register-confirm-password-input').val('');
}

$("#relation-date-input").datepicker({
  onSelect: function(dateText) {
    relation_date = dateText;
  },
  dateFormat: 'dd.mm.yy'
});

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function ShowSnackbar(show, text) {
  $('#snackbar').text(text);
  $('#snackbar').addClass("show");
  setTimeout(function () {
    $('#snackbar').removeClass("show");
  }, 3000);
}

function GetRelationHistory() {

  $.ajax({
    type: "GET",
    url: "php/GetRelationHistory.php",
    success: function(data) {
      $('#relation-history tbody').empty();
      var relations_array = data.split("|");

      var index = relations_array.length - 1;
      if (index > -1) {
        relations_array.splice(index, 1);
      }

      $.each(relations_array, function(key, value) {
        var current_info = value.split("_");
        $('#relation-history tbody').append('<tr><td>' + current_info[0] +
          '</td><td>' + current_info[1] + '</td><td>' +
          current_info[2] +
          '</td>');
      });

    }
  });

}

function ToggleStar() {

  if ($('#favourite-star').hasClass('fave-active')) {
    $('#favourite-star').removeClass('fave-active');
  } else {
    $('#favourite-star').addClass('fave-active');
  }

}

function ToggleFavourite() {

  var edit_type = "";

  if ($('.fav-text').hasClass('faved')) {
    edit_type = "remove";
  } else {
    edit_type = "add";
  }

  $.ajax({
    type: "POST",
    url: "php/EditFavourite.php",
    data: {
      originLocation: origin_location,
      destinationLocation: destination_location,
      editType: edit_type
    },
    success: function(data) {

      if (data.indexOf("ERROR") > 0) {
        ShowSnackbar(true, "Napaka pri urejanju priljubljenih!");
      }

      if (edit_type == "add")
      {
        ShowSnackbar(true, "Dodano med priljubljene!");
        $('.fav-text').addClass('faved');

      }
      else
      {
        ShowSnackbar(true, "Izbrisano iz priljubljenih!");
        $('.fav-text').removeClass('faved');
      }
    }
  });

}

function ProcessQueryParams() {
  if (getParameterByName("login", document.location.search) != null) {
    ShowSnackbar(true, "Uspešno ste se prijavili!");
  }
  if (getParameterByName("register", document.location.search) != null) {
    ShowSnackbar(true, "Uspešno ste se registrirali! Sedaj se lahko prijavite.");
  }
  if (getParameterByName("logout", document.location.search) != null) {
    ShowSnackbar(true, "Uspešno ste se odjavili.");
  }
}

function AssignClickFunctions() {
  $('#login-title').click(function() {
    ClearInputFields();
  });

  $('#register-title').click(function() {
    ClearInputFields();
  });

  $('#switch-relations-column').click(function() {
    SwitchRelations(switch_relations);
  });

  $('#search-relations-button').click(function() {
    UpdateValues();
  });

  $('#favourite-star').click(function() {
    ToggleStar();
  });

  $('.fav-text').click(function() {
    ToggleFavourite();
  });

  $('#home-tab-button').click(function() {
    $('#relations-wrapper').show();
    $('#relations-input-wrapper').show();
    $('#relation-history-wrapper').hide();
    $('.sidebar').sidebar('hide');
  });

  $('#history-tab-button').click(function() {
    $('#relations-wrapper').hide();
    $('#relations-input-wrapper').hide();
    $('#relation-history-wrapper').show();
    $('.sidebar').sidebar('hide');
    GetRelationHistory();
  });
}

function SetupWebsite() {

  switch_relations = false;

  $.getJSON("res/stations.json", function(data) {
    $.each(data, function(val, key) {
      stations.push(key["location"]);
    });
  });

  // Use this to start showing results
  // only when 3 letters or more are typed
  // - reduces lag on devices
  $("#origin-relation-input").autocomplete({
    minLength: 3,
    source: function(request, response) {
      var results = $.ui.autocomplete.filter(stations, request.term);
      response(results.slice(0, 20));
    },
    select: function(event, ui) {
      if (ui["item"] != null) {
        origin_location = ui["item"]["label"];

        if (updateRelationsOnInputEnter) {
          UpdateValues();
        }
      }
    }
  });

  $("#destination-relation-input").autocomplete({
    minLength: 3,
    source: function(request, response) {
      var results = $.ui.autocomplete.filter(stations, request.term);
      response(results.slice(0, 20));
    },
    select: function(event, ui) {
      if (ui["item"] != null) {
        destination_location = ui["item"]["label"];

        if (updateRelationsOnInputEnter) {
          UpdateValues();
        }
      }
    }
  });

  $('#relations').hide();
  $('#fav-text').hide();
  $(".ui.accordion").accordion();

  $("#relation-date-input").datepicker('setDate', 'today');
  relation_date = $('#relation-date-input').val();

  $('#header-wrapper').data('size', 'big');
  travelCost = "0.0";
}

function SwitchRelations(toggle) {
  if (toggle) {
    $("#switch-relations-column").removeClass("switch-relations-active");
    switch_relations = false;
  } else {
    $("#switch-relations-column").addClass("switch-relations-active");
    switch_relations = true;
  }
}

function SwitchRelationsValues() {
  var newOriginLocation = destination_location;
  switched_destination_location = origin_location;
  switched_origin_location = newOriginLocation;
}

function UpdateValues() {

  $('#fav-text').hide();

  if (origin_location == null || destination_location == null)
    return;

  ToggleRelationsLoader(true);
  ToggleError(false, "");

  if (switch_relations) {
    SwitchRelationsValues();
  }

  var current_origin_location = (switch_relations ? switched_origin_location : origin_location);
  var current_destination_location = (switch_relations ? switched_destination_location : destination_location);

  var APIEndpoint = "http://mihamacek.com:2392/api/v2/route?origin=" +
    current_origin_location +
    "&destination=" + current_destination_location +
    "&date=" + relation_date;

  $.ajax({
    type: 'GET',
    dataType: 'json',
    url: APIEndpoint,
    success: function(data) {

      $.ajax({
        type: 'POST',
        url: 'php/CheckFavourite.php',
        data: {
          originLocation: current_origin_location,
          destinationLocation: current_destination_location
        },
        success: function(data) {
          if (data.indexOf("ERROR") <= 0) {
            if (data == "exists" && $('.fav-text').hasClass('faved') == false) {
              $('.fav-text').addClass('faved');
            } else if (data == "notexists" && $('.fav-text').hasClass('faved')) {
              $('.fav-text').removeClass('faved');
            }
          } else {
            ShowSnackbar(true, "Napaka pri priljubljenih");
          }
        }
      });

      UpdateTravelInfo(data);
      ToggleError(false, "");

      $('#relations tbody').empty();

      var currentDate = new Date();
      var currentHour = addZero(currentDate.getHours());
      var currentMinute = addZero(currentDate.getMinutes());
      var currentTime = currentHour + ":" + currentMinute;

      var currentDay = addZero(currentDate.getDate());
      var currentMonth = addZero(currentDate.getMonth() + 1);
      var currentYear = currentDate.getFullYear();
      var today = currentDay + "." + currentMonth + "." + currentYear;

      var todayDate = new Date(today);
      var pickedDate = new Date(relation_date);

      if (pickedDate.getTime() == todayDate.getTime()) {
        $('#relations tbody').append("<tr><td colspan='4' style='padding: 0'>"
        + "<div id='missedRelationsAccordion' class='ui styled accordion'>"
            + "<div class='title'>"
            + "<i class='dropdown icon'></i>"
            + "Pretekle relacije"
            + "</div>"
            + "<div class='content'>"
              + "<table>"
                + "<thead>"
                  + "<tr><th></th><th></th><th></th><th></th></tr>"
                + "</thead>"
                + "<tbody></tbody>"
              + "</table>"
            + "</div>"
          + "</div>"
          +"</td></tr>");
        $("#missedRelationsAccordion").accordion();
      }

      for (var i = 0; i < departureTimes.length; i++) {

        if (pickedDate.getTime() == todayDate.getTime()) {
          (currentTime > departureTimes[i] ?
            $("#missedRelationsAccordion .content table")
            :
            $('#relations')).append('<tr><td>' + departureTimes[i] +
            '</td><td>' + arrivalTimes[i] + '</td><td>' +
            travelTimes[i] +
            '</td><td>' + travelCost + '€</td></tr>');
          } else {
            $('#relations').append('<tr><td>' + departureTimes[i] +
            '</td><td>' + arrivalTimes[i] + '</td><td>' +
            travelTimes[i] +
            '</td><td>' + travelCost + '€</td></tr>');
          }
      }

      $('#fav-text').show();
      ToggleRelationsLoader(false);

      LogRelation(origin_location, destination_location);

    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('#relations tbody').empty();
      var errorCode = jqXHR["status"];
      ToggleRelationsLoader(false);
      ToggleError(true, errorCode);
      $('#relations').hide();
    }
  });

}

// Used for timedate to add 0 in
// front of single character number
function addZero(i) {
  if (i < 10) {
      i = "0" + i;
  }
  return i;
}

function ToggleRelationsLoader(show) {
  if (show) {
    $("#relations-loader").show();
    $('#relations').hide();
    $('#origin-relation-input').prop('disabled', true);
    $('#destination-relation-input').prop('disabled', true);
    $('#relation-date-input').prop('disabled', true);
    $('#search-relations-button').prop('disabled', true);
  } else {
    $("#relations-loader").hide();
    $('#relations').show();
    $('#origin-relation-input').prop('disabled', false);
    $('#destination-relation-input').prop('disabled', false);
    $('#relation-date-input').prop('disabled', false);
    $('#search-relations-button').prop('disabled', false);
  }
}

function ToggleAuthenticationLoader(show) {
  if (show) {
    $("#authentication-loader").show();
    $(".authenticate.item").hide();
  } else {
    $("#authentication-loader").hide();
    $(".authenticate.item").show();
  }
}

function ShowAuthenticationError(data, authType) {
  if (authType=="register") {
    // SHOW REGISTER ERROR
    var errorObject = $('#register-error');
    errorObject.text("");

    var errors;
    if (data.indexOf('-') >= 0) {
      errors = data.split("-");
    }

    if ($.isArray(errors)) {
      data = errors[0];
    }

    if (data == "ERR_DUPLICATE_USR") {
      errorObject.append("To uporabniško ime je že registrirano!");
    } else if (data == "ERR_DUPLICATE_EMAIL") {
      errorObject.append("Ta e-poštni naslov je že registriran!");
    } else if (data == "ERR_INSERT") {
      errorObject.append("Napaka v vstavljanju v podatkovno bazo. Prosimo kontaktirajte administratorja.");
    } else if (
      data=="ERR_NULL_REGISTERUSERNAME" ||
      data=="ERR_NULL_REGISTEREMAIL" ||
      data=="ERR_NULL_REGISTERPASSWORD" ||
      data=="ERR_NULL_REGISTERCONFIRMPASSWORD"
    ) {
      errorObject.append("Prosimo izpolnite vsa polja!");
    } else if (data=="ERR_INVALID_REGISTEREMAIL") {
      errorObject.append("Napačen e-poštni naslov!");
    } else if (data=="ERR_DIFFERENT_REGISTERPASSWORDS") {
      errorObject.append("Gesli se ne ujemata!");
    } else {
      errorObject.append("Neznana napaka. Prosimo kontaktirajte administratorja.");
    }
  } else {
    // SHOW LOGIN ERROR
    var errorObject = $('#login-error');
    errorObject.text("");
    if (data == "ERR_INVALID_INFO") {
      errorObject.append("Vnesili ste napačne informacije!");
    } else if (
      data == "ERR_NULL_LOGINUSERNAME" ||
      data == "ERR_NULL_LOGINPASSWORD"
    ) {
      errorObject.append("Prosimo izpolnite vsa polja!");
    } else {
      errorObject.append("Neznana napaka. Prosimo kontaktirajte administratorja.");
    }
  }
}

function ToggleError(show, errCode) {
  if (show) {
    $(".error-wrapper").show();
    $(".error-wrapper .error-code-text").text("Napaka " + errCode);
  } else {
    $(".error-wrapper").hide();
  }
}

function UpdateTravelInfo(data) {
  departureTimes = [];
  arrivalTimes = [];
  travelTimes = [];

  $.each(data, function(val, key) {
    departureTimes.push(key["departure"]);
    arrivalTimes.push(key["arrival"]);
    travelTimes.push(key["travel_time"]);
    travelCost = key["price"];
  });

}

function LogRelation(origin_location, destination_location) {

  $.ajax({
    type: 'POST',
    url: 'php/LogRelation.php',
    data: {
      originLocation: origin_location,
      destinationLocation: destination_location
    }
  });

}
