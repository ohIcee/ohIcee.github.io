$(document).ready(function() {

  GetSurveys();
  // CreateSurveyItem(5, "Anketa #1", "Marko Plaznik");

  AssignClickFunctions();

  $("body").fadeIn(300, "swing");
});

function CreateSurveyItem(SurveyID, SurveyName, SurveyAuthor) {
  var SurveyList = $("#survey_list");
  SurveyList.append(""
  + "<div id='" + SurveyID + "' class='survey item'>"
    + "<i class='large envelope outline open middle aligned icon'></i>"
    + "<div class='content'>"
      + "<a class='header'>" + SurveyName + "</a>"
      + "<div class='description'>Survey created by " + SurveyAuthor + "</div>"
    + "</div>"
  + "</div>"
  );
}

function GetSurveys() {
  $.ajax({
    type: 'GET',
    async: false,
    dataType: 'json',
    url: 'php/GetSurveys.php',
    success: function(data) {
      ProcessJSON(data);
    }
  });

  function ProcessJSON(data) {
    $(".ui.active.inverted.dimmer").remove();

    $.each(data, function(key, value) {
      CreateSurveyItem(value.ID, value.Name, value.Author);
    });
  }
}

function SendSurvey(SurveyID) {
  // Redirect to Answer Page with this in page
  document.location.href = "answerSurvey.html?id=" + SurveyID;
}

function AssignClickFunctions() {

  $("#survey_list .survey.item").click(function() {
    SendSurvey(this.id);
  });

  $("#CreateSurveyButton").click(function() {
    window.location.href = "createSurvey.html";
  });

}
