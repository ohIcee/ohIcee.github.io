function GetStations() {
  $.getJSON( "./res/stations.json", function(data) {
    FillDataList(data);
  } );

  function FillDataList(stations) {
    $.each(stations, function(i, e) {
      var optionElement = document.createElement("option");
      optionElement.value = e;
      $("#stations-datalist").append(optionElement);
    });
  }
}

function SetTodayDate() {
  var date = new Date();
  var day = addZero(date.getDate());
  var month = addZero(date.getMonth() + 1);
  var year = date.getFullYear();
  var today = year + "-" + month + "-" + day;
  $("#date-input").val(today);

  function addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
  }
}

function FixDateFormat(date) {

  var splitDate = date.split('-');
  var year = splitDate[0];
  var month = splitDate[1];
  var day = splitDate[2];

  return day + "." + month + "." + year;
}

function SearchRelation() {

  ResetState();
  ToggleLoadingIndicator(true);

  GetFirstStationID();

  function GetFirstStationID() {
    if ( $("#origin-location-input").val().length > 1 ) {
      GetStationID($("#origin-location-input").val(), -1);
    } else {
      ToggleErrorMessage(true, "Prosimo vnesite vstopno postajo!");
    }
  }

  function GetSecondStationID(firstID) {
    if ( $("#destination-location-input").val().length > 1 ) {
      GetStationID($("#destination-location-input").val(), firstID);
    } else {
      ToggleErrorMessage(true, "Prosimo vnesite izstopno postajo!");
    }
  }

  function GetStationID(stationName, firstStationID) {
    $.ajax({
        url: 'https://vozovnice.nomago.si/api/v1/destinations',
        dataType: 'JSON',
        type: 'POST',
        contentType: 'application/x-www-form-urlencoded',
        data: {
          name: stationName,
          language_id: 1
        },
        success: function( data, textStatus, jQxhr ){
          if (data.length <= 0) {
            OnInvalidStationName();
            return;
          }
          if (firstStationID == -1) {
            GetSecondStationID(data[0].code);
          } else {
            GetRelationInfo(firstStationID, data[0].code);
          }
        },
        error: function( jqXhr, textStatus, errorThrown ){
          //console.log( errorThrown );
          OnInvalidStationName();
        }
    });
  }

  function GetRelationInfo(firstStationID, secondStationID) {

    var originLocation = firstStationID;
    var destinationLocation = secondStationID;
    var date = FixDateFormat($("#date-input").val());
    var switchRelation = $("#switch-relation-input").is(":checked") ? true : false;

    var correctOriginLocation = (switchRelation == false) ? originLocation : destinationLocation;
    var correctDestinationLocation = (switchRelation == false) ? destinationLocation : originLocation;

    $.ajax({
        url: 'https://vozovnice.nomago.si/api/v1/departures',
        dataType: 'JSON',
        type: 'POST',
        contentType: 'application/x-www-form-urlencoded',
        data: {
          adult: 1,
          children: 0,
          children_2: 0,
          departure: date,
          from_code: correctOriginLocation,
          oneWayTicket: true,
          return: date,
          to_code: correctDestinationLocation
        },
        success: function( data, textStatus, jQxhr ){
          ToggleLoadingIndicator(false);

          data = data.departures;

          $.each(data, function(i, e) {
            var string = '<div class="item"><span class="rideTime">'+e.rideTime+'</span><span> <i class="fas fa-caret-right"></i> </span><span>'+e.arrivedAt+'</span><span class="price">'+e.price+'€</span></div>';
            $("#result-list-wrapper").append(string);
          });

        },
        error: function( jqXhr, textStatus, errorThrown ){
          console.log(jqXhr);
          ToggleErrorMessage(true, jqXhr.responseJSON.errorMsg);
        }
    });
  }

}

function ToggleErrorMessage(toggle, message) {
  ToggleLoadingIndicator(false);
  if (toggle) {
    $("#error-wrapper").removeClass('hide');
    $("#error-wrapper .error-msg").text(message);
  } else {
    $("#error-wrapper").addClass('hide');
  }
}

function ToggleLoadingIndicator(toggle) {
  if (toggle) { $("#relation-loader-wrapper").removeClass('hide'); }
  else { $("#relation-loader-wrapper").addClass('hide'); }
}

function ResetState() {
  ToggleErrorMessage(false, "");
  ToggleLoadingIndicator(false);
  $("#result-list-wrapper").html("");
}

$(document).ready(function() {
  GetStations();
  SetTodayDate();
  $("#search-button").click(SearchRelation);
});
