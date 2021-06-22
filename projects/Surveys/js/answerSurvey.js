var SurveyID;
var CurrentSurvey;

$(document).ready(function() {

  CurrentSurvey = new Survey();

  $("body").fadeIn(300, "swing");
  SurveyID = getParameterByName("id");
  GetSurveyInfo();

  $('.ui.checkbox').checkbox();

  ChangeQuestion(0);
});

function ChangeQuestion(questionID) {
  $(".ui.items.module").hide()
  $(".ui.items.module#" + questionID).show();
}

function IncrementQuestion(btnElement) {
  var questionID = btnElement.closest(".ui.items.module").id;
  ChangeQuestion(++questionID);
}

function ShowResults() {
  window.location.href = "surveyResults.html?id=" + SurveyID;
}

// Get Survey INFO from database
function GetSurveyInfo() {
  $.ajax({
    type: 'GET',
    async: false,
    dataType: 'json',
    data: {
      surveyID: SurveyID
    },
    url: 'php/GetSurveyInfo.php',
    success: function(data) {
      ProcessSurveyInfo(data);
    }
  });

  // Save Survey Into Object
  function ProcessSurveyInfo(data) {
    var ParsedJSON = JSON.parse(data.info);

    // Store survey name into object
    CurrentSurvey.ChangeName(ParsedJSON.name);

    // Save survey modules/answers into survey object
    $.each(ParsedJSON.modules, function(key, value) {
      var CurrentModule = new Module();
      CurrentModule.ChangeQuestion(value.question);
      CurrentModule.ChangeHasFreeInput(value.hasFreeInput);
      CurrentModule.ChangeQuestionType(value.questionType);
      $.each(value.answers, function(key, value) {
        var CurrentAnswer = new Answer(value);
        CurrentModule.AddAnswer(CurrentAnswer);
      });
      CurrentSurvey.AddModule(CurrentModule);
    });

    // Load modules into pages
    LoadSurvey();
  }
}

// Store survey answers into object then JSON
var AnsweredSurvey;
function FinishSurvey() {

  AnsweredSurvey = new Survey();
  AnsweredSurvey.ChangeName(CurrentSurvey.name);

  // Get Answer Values
  var Modules = $(".ui.items.module");
  $.each(Modules, function(moduleKey, moduleValue) {
    var CurrentModule = new Module();
    var Inputs = $(this).find("input");
    $.each(Inputs, function(inputKey, inputValue) {
      var CurrentAnswer = new Answer();
      var value = inputValue.value;

      // Check if radio / checkbox / free input
      if (inputValue.type == "radio") {
        CurrentAnswer.ChangeAnswer($("input[name='" + inputValue.name + "']:checked").val());
        CurrentModule.AddAnswer(CurrentAnswer);
      } else if (inputValue.type == "checkbox") {
        // Add each checked checkbox as answer
        $.each($("input[name='" + inputValue.name + "']:checked"), function(checkboxKey, checkboxValue) {
          var answerValue = $(this).val();
          CurrentAnswer = new Answer();
          CurrentAnswer.ChangeAnswer(answerValue);
          CurrentModule.AddAnswer(CurrentAnswer);
        });
      } else if (inputValue.type == "text") {
        CurrentAnswer.ChangeAnswer(value);
        CurrentModule.AddAnswer(CurrentAnswer);
      }

      // Iterate inputs only once (block double checks/adds)
      return false;
    });
    AnsweredSurvey.AddModule(CurrentModule);
  });

  // TODO Error check

  $("#content-wrapper").slideUp();

  // Turn answers object into JSON and save it to phpmyadmin
  var SurveyJSON = JSON.stringify(AnsweredSurvey);
  $.ajax({
    type: 'POST',
    url: 'php/SubmitSurveyAnswer.php',
    data: {
      surveyID: SurveyID,
      SurveyInfoJSON: SurveyJSON
    },
    success: function(data) {
      if (data == "SUCCESS_INSERT") {
        $("#after-upload-content .ui.message").addClass("success");
        $("#after-upload-content .header").text("Vaše rešitve ankete so bile uspešno objavljene!");
      } else {
        $("#after-upload-content .ui.message").addClass("error");
        $("#after-upload-content .header").text("Pri objavi rešitev ankete je prišlo do napake!");
      }

      $("#after-upload-content .ui.message").show();
      $("#after-upload-content").slideDown();
    }
  });

}

function LoadSurvey() {

  // Set Survey Name
  $("#header").text(CurrentSurvey.name);

  // Generate tabs
  $.each(CurrentSurvey.modules, function(moduleKey, moduleValue) {

    // Store question type Div and Input info into variables
    // used for radio/checkbox forms
    var questionTypeDiv = "";
    var questionTypeInput = "";
    if (moduleValue.questionType == "singleanswerquestion") {
      questionTypeDiv = "radio";
      questionTypeInput = "type='radio'";
    } else if (moduleValue.questionType == "multipleanswerquestion") {
      questionTypeDiv = "";
      questionTypeInput = "type='checkbox'";
    }

    // Save answerString dependent on the question type
    var answersString = "";
    if (moduleValue.questionType != "customanswerquestion") {
      $.each(moduleValue.answers, function(answerKey, answerValue) {

        answersString += ""
        + "<div class='ui form answer'>"
          + "<div class='grouped fields'>"
            + "<div class='field'>"
              + "<div class='ui checkbox " + questionTypeDiv + "'>"
                + "<input value='" + answerValue.answer + "' " + questionTypeInput + " name='" + moduleKey + "'>"
                + "<label>" + answerValue.answer + "</label>"
              + "</div>"
            + "</div>"
          + "</div>"
        + "</div>";

      });
    } else {
      answersString += ""
      + "<div class='ui form answer'>"
        + "<div class='grouped fields'>"
          + "<div class='field'>"
            + "<div class='ui input'>"
              + "<input type='text' value='stuff'>"
            + "</div>"
          + "</div>"
        + "</div>"
      + "</div>"
    }

    // Add a "?" to the question if there is none and
    // capitalize first letter
    var questionString = moduleValue.question;
    if (questionString[questionString.length - 1] != "?") {
      questionString += "?";
    }
    questionString = CapitalizeFirstLetter(questionString);

    // Store button string dependent on if it's the last question or not
    var btnString = ((moduleKey + 1) == CurrentSurvey.modules.length) ? "Končaj" : "Nadaljuj";
    var btnClasses = "ui button";
    var btnOnClick = "";

    // If it's the last button add positive class
    if (btnString == "Končaj") {
      btnClasses += " positive";
    }

    // Store button onclick functions dependent on button position
    // in modules
    if (btnString == "Nadaljuj") {
      btnOnClick = "onclick='IncrementQuestion(this)'";
    } else if (btnString == "Končaj") {
      btnOnClick = "onclick='FinishSurvey()'";
    }

    // Create the module tab from the stored variables
    $("#module-tabs").append(""
    + "<div id='" + moduleKey + "' class='ui items module'>"
      + "<div class='item'>"
        + "<div class='content'>"
          + "<div class='header'>" + questionString + "</div>"
          + "<div class='description'>"
            + answersString
          + "</div>"
          + "<div class='extra'>"
            + "<div class='" + btnClasses + "' " + btnOnClick + ">"
              + btnString
            + "</div>"
          + "</div>"
        + "</div>"
      + "</div>"
    + "<div>"
    );

    // Append a page tab on the bottom bar with a tooltip and onclick function
    $("#tab-pages").append("<a onclick='ChangeQuestion(" + moduleKey + ")' data-position='top left' data-tooltip='" + questionString + "' class='item'>" + (moduleKey + 1) + "</a>").popup();

  });

}

function CapitalizeFirstLetter(str) {
  str = str.toLowerCase().replace(/^[\u00C0-\u1FFF\u2C00-\uD7FF\w]|\s[\u00C0-\u1FFF\u2C00-\uD7FF\w]/g, function(letter) {
    return letter.toUpperCase();
  });
  return str;
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

class Survey {

  constructor() {
    this.name = name;
    this.modules = new Array();
  }

  ChangeName(newName) {
    this.name = newName;
  }

  AddModule(module) {
    this.modules.push(module);
  }

  RemoveModule(index) {
    this.modules.splice(index, 1);
  }

}

class Module {

  constructor() {
    this.question = "QUESTION_NULL";
    this.answers = new Array();
    this.hasFreeInput = false;
    this.questionType = "QUESTIONTYPE_NULL";
  }

  ChangeQuestion(newQuestion) {
    this.question = newQuestion;
  }

  ChangeHasFreeInput(hasFreeInput) {
    this.hasFreeInput = hasFreeInput;
  }

  AddAnswer(answer) {
    this.answers.push(answer);
  }

  ChangeQuestionType(questionType) {
    this.questionType = questionType;
  }

}

class Answer {

  constructor(answer) {
    this.answer = answer;
  }

  ChangeAnswer(newAnswer) {
    this.answer = newAnswer;
  }

}
