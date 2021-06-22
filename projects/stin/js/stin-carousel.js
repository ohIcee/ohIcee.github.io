var currIndex = 0;
var imgUrls = [
  "res/carousel-gas-optimized.png",
  "res/carousel-hvac-optimized.jpg",
  "res/carousel-hydronics-optimized.jpg"
];

var preloadedImages = [];

var headerTexts = [
  "Prepustite delo profesionalcem",
  "ESCO - energetsko pogodbeništvo",
  "Reference - za vas smo izvedli"
];

var paragraphsTexts = [
  "<button onclick='showOPodjetju()' class='ui red button carousel'>Pridružite se našim zadovoljnim strankam</button>",
  "<button onclick='ShowESCO()' class='ui red button carousel'>Več informacij</button>",
  "<button onclick='ShowReference()' class='ui red button carousel'>Prikaži reference</button>"
];

var sliderTimer;

function ShowESCO() {
  window.location.href='ESCO.html';
}

function ShowReference() {
  window.location.href='vse.php?type=reference';
}

function showOPodjetju() {
  window.location.href='opodjetju.html';
}

function preloadImages() {

  for (var i = 0; i < imgUrls.length; i++) {
    preloadedImages[i] = new Image();
    preloadedImages[i] = imgUrls[i];
  }

  $(".jumbotron").css("background-image", "url("+preloadedImages[0]+")");

}

$(document).ready(function() {

  setSlide(0);

  preloadImages();

  startTimer();
});

function startTimer() {
  sliderTimer = setInterval(function() {
    nextSlide();
  }, 5000);
}

function nextSlide() {
  currIndex++;

  if (currIndex > preloadedImages.length - 1) { currIndex = 0; }

  setSlide(currIndex);
}

function onSliderDot(index) {
  clearInterval(sliderTimer);
  setSlide(index);
  startTimer();
}

function setSlide(index) {
  currIndex = index;

  setJumbotronImage( preloadedImages[currIndex] );
  setHeader( headerTexts[currIndex] );
  setActiveDot(index);

  setParagraph( paragraphsTexts[currIndex], true );
}

function setActiveDot(index) {
  var dots = $(".slider-dot-control label");
  $.each(dots, function(index, value) {
    $(value).removeClass("slider-dot-active");
  });
  $(".slider-dot-control #" + index).addClass("slider-dot-active");
}

function setHeader(text) {
  $("#carousel-header").text(text);
}

function setParagraph(text, isLink) {
  if (!isLink) {
    $("#carousel-paragraph").text(text);
  } else {
    $("#carousel-paragraph").text("");
    $("#carousel-paragraph").append(text);
  }
}

function setJumbotronImage(url) {
  $(".jumbotron").css("background-image", "url("+url+")");
}
