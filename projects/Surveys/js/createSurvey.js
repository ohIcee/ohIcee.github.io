/*
SingleAnswer Survey: <i class="check circle outline icon"></i>
MultipleAnswers Survey: <i class="check circle outline icon"></i>
CustomAnswer Survey: <i class="edit outline icon"></i>
*/

var CurrentSurvey;

$(document).ready(function() {
  CurrentSurvey = new Survey();
  $('.ui.checkbox').checkbox({
    onChecked: function() {
      if ( $(this).val() == "customanswerquestion" ) {
        // Hide Answers Inputs
        ToggleCustomAnswerQuestion(false);
      } else {
        // Show Answers Inputs
        ToggleCustomAnswerQuestion(true);
      }
    }
  });
  LoadModules();
  AssignClickFunctions();
  $("body").fadeIn(300);
});

function ToggleCustomAnswerQuestion(show) {

  var QuestionInputsWrapper = $("#question-inputs-wrapper");
  var QuestionAddButtons = $("#add-input-button");
  var FreeInput = $("#generated-inputs");

  if (show) {
    QuestionInputsWrapper.slideDown();
    QuestionAddButtons.slideDown(100);
    FreeInput.slideDown();
  } else {
    QuestionInputsWrapper.slideUp();
    QuestionAddButtons.slideUp(100);
    FreeInput.slideUp();
  }
}

function CreateCurrentModule(QuestionType, QuestionName) {
  var QuestionTypeIcon = GetIconFromQuestionType(QuestionType);
  var CurrentModulesList = $("#current-modules-list");
  CurrentModulesList.append(""
  + "<div class='item'>"
    + "<div class='right floated content'>"
      + "<div class='remove-current-module-btn'>Delete</div>"
    + "</div>"
    + QuestionTypeIcon
    + "<div class='content'>"
      + "<div class='header module-question-name'>"  + QuestionName + "<div>"
    + "</div>"
  + "<div>"
  );
}

function LoadModules() {
  $("#current-modules-list").empty().append("<div class='header'>Current Question Modules</div>");

  var Modules = CurrentSurvey.modules;
  if (Modules.length > 0) {
    $.each(Modules, function(key, value) {
      CreateCurrentModule(value.questionType, value.question);
    });
    AssignCurrentModulesClickFunctions();
  } else {
    $("#current-modules-list").append("<div class='item'>The survey is empty! Add questions!</div>");
  }

}

function AssignCurrentModulesClickFunctions() {
  $(".remove-current-module-btn").click(function() {
    $(this).closest(".item").slideUp(function() {
      var thisQuestionName = $(this).find(".module-question-name").text();
      for (var i = 0; i < CurrentSurvey.modules.length; i++) {
        if (CurrentSurvey.modules[i].question == thisQuestionName) {
          CurrentSurvey.RemoveModule(i);
          return false;
        }
      }
      $(this).remove();
    });
  });
}

function AssignClickFunctions() {

  AssignCurrentModulesClickFunctions();

  $("#survey-name-input").change(function() {
    var NewText = $("#survey-name-input").val();
    CurrentSurvey.ChangeName(NewText);
  });

  $("#add-question-cards .ui.button").click(function() {
    var parentElementID = $(this).closest(".column").attr('id');
    if (~parentElementID.indexOf("new-question-card")) {
      // Single Answer Question
      if ($("#" + parentElementID + " .ui.button").hasClass("negative")) {
        ShowNewQuestionTab(false);
        return;
      }
      ShowNewQuestionTab(true);
    } else {
      alert("Error!");
    }
  });

  $("#free-input-checkbox").change(function() {
    if (this.checked) {
      CreateQuestionAnswerInput(true);
    } else {
      $("#new-question-tab #free-input").remove();
    }
  });

  $("#new-question-tab #add-input-button").click(function() {
    CreateQuestionAnswerInput(false);
  });

  $("#submit-new-question-button").click(function() {
    SubmitNewQuestion();
  });

  $("#cancel-creating-survey-button").click(function() {
    window.location.href = "index.html";
  });

  $("#finish-creating-survey-button").click(function() {
    SubmitSurvey();
  });

  $("#after-upload-content .ui.button").click(function() {
    window.location.href = "index.html";
  });
}

function SubmitSurvey() {

  $("#content-wrapper").slideUp();
  var SurveyJSON = JSON.stringify(CurrentSurvey);

  $.ajax({
    type: 'POST',
    url: 'php/CompleteSurvey.php',
    data: {
      surveyName: CurrentSurvey.name,
      surveyInfoJSON: SurveyJSON
    },
    success: function(data) {
      if (data == 'SUCCESS_INSERT') {
        $("#after-upload-content .ui.message").addClass("success");
        $("#after-upload-content .header").text("Your survey was succesfully submitted!");
      } else {
        $("#after-upload-content .ui.message").addClass("error");
        $("#after-upload-content .header").text("Oops! There was a problem when uploading your survey.");
      }
      $("#after-upload-content .ui.message").show();
      $("#after-upload-content").slideDown();
    }
  });

}

function ToggleErrorMessage(show, errors) {
  var ErrorMessageElement = $(".ui.error.message");
  if (show) {
    ErrorMessageElement.find(".list").empty();
    $.each(errors, function(key, value) {
      ErrorMessageElement.find(".list").append(""
      + "<li>" + value + "</li>"
      );
    });
    ErrorMessageElement.slideDown();
  } else {
    ErrorMessageElement.slideUp();
  }
}

function SubmitNewQuestion() {

  var errors = new Array();

  var QuestionAnswerInputs = $("#new-question-tab .new-question-input");

  var Question = $("#question-name").val();
  var HasFreeInput = $("#free-input-checkbox-wrapper").hasClass("checked") ? true : false;
  var QuestionAnswers = new Array();
  var QuestionType = $("input[name='question-type']:checked").val();

  if (Question.length < 2) {
    errors.push("The question is too short!");
  }

  $("#new-question-form").addClass("loading");

  var newModule = new Module();
  newModule.ChangeQuestion(Question);
  newModule.ChangeQuestionType(QuestionType);

  if ( !$(".ui.radio.checkbox.customanswerquestion input").is(':checked')) {
    newModule.ChangeHasFreeInput(HasFreeInput);
    // Put Answers to Question into an array and Module
    $.each(QuestionAnswerInputs, function(key, value) {
      var inputValue = $(value).val();
      if (inputValue != "") {
        QuestionAnswers.push(new Answer(inputValue));
        newModule.AddAnswer(inputValue);
      }
    });

    if (QuestionAnswers.length < 2) {
      errors.push("Please add at least 2 answers!");
    }
  }

  if (errors.length > 0) {
    $("#new-question-form").removeClass("loading");
    ToggleErrorMessage(true, errors);
    return;
  } else {
    ToggleErrorMessage(false, null);
  }

  CurrentSurvey.AddModule(newModule);
  ResetNewQuestionTab();

  setTimeout(function () {
    $("#new-question-form").removeClass("loading");
  }, 500);
}
function ResetNewQuestionTab() {

  ShowNewQuestionTab(false);

  $("#question-name").val("");
  $("#free-input-checkbox-wrapper").removeClass("checked");

  var QuestionAnswerInputs = $("#new-question-tab .new-question-input");
  $.each(QuestionAnswerInputs, function(key, value) {
    $(value).val("");
  });
}

function ShowNewQuestionTab(show) {
  if (show) {
    $("#current-modules-list").slideUp();
    $("#new-question-card .ui.button").addClass("negative").text("Close");
    $("#create-question-section").slideDown();
  } else {
    $("#current-modules-list").slideDown();
    $("#new-question-card .ui.button").removeClass("negative").text("Add");
    $("#create-question-section").slideUp();
  }
}

function CreateQuestionAnswerInput(IsFreeInput) {

  var ParentElement = $("#new-question-tab");

  if (IsFreeInput) {
    ParentElement.find("#generated-inputs").append(""
    + "<div id='free-input' class='field'>"
      + "<div class='ui input'>"
        + "<input placeholder='Other...' disabled type='text'>"
      + "</div>"
    + "<div>");
  } else {
    ParentElement.find("#question-inputs-wrapper").append(""
    + "<div class='field'>"
      + "<div class='ui action input'>"
        + "<input class='new-question-input' required type='text'>"
        + "<div onclick='RemoveInput(this)' class='ui negative button'>"
          + "Odstrani"
        + "</div>"
      + "</div>"
    + "<div>");
  }

}

function RemoveInput(InputElement) {
  InputElement.closest(".field").remove();
}

function GetIconFromQuestionType(QuestionType) {
  switch (QuestionType) {
    case "singleanswerquestion":
      return '<i class="check circle outline icon"></i>';
    case "multipleanswerquestion":
      return '<i class="check square outline icon"></i>';
    case "customanswerquestion":
      return '<i class="edit outline icon"></i>';
    default:
      return 'NULL';
  }
}

class Survey {

  constructor() {
    this.name = name;
    this.modules = new Array();
  }

  ChangeName(newName) {
    this.name = newName;
    this.CheckValidity();
  }

  AddModule(module) {
    this.modules.push(module);
    LoadModules();
    this.CheckValidity();
  }

  RemoveModule(index) {
    this.modules.splice(index, 1);
    LoadModules();
    this.CheckValidity();
  }

  CheckValidity() {
    if (this.name.length > 3 && this.modules.length > 0) {
      $("#finish-creating-survey-button").removeClass("disabled");
    } else {
      $("#finish-creating-survey-button").addClass("disabled");
    }
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
