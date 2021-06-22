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
  "Pridružite se našim zadovoljenim strankam!",
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

function preloadImages() {

  for (var i = 0; i < imgUrls.length; i++) {
    preloadedImages[i] = new Image();
    preloadedImages[i] = imgUrls[i];
  }

  $(".jumbotron").css("background-image", "url("+preloadedImages[0]+")");

}

$(document).ready(function() {

  preloadImages();

  $(".prev-slide").click(function() {
    clearInterval(sliderTimer);
    prevSlide();
    startTimer();
  });

  $(".next-slide").click(function() {
    clearInterval(sliderTimer);
    nextSlide();
    startTimer();
  });

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

function prevSlide() {
  currIndex--;

  if (currIndex < 0) { currIndex = preloadedImages.length - 1; }

  setSlide(currIndex);
}

function setSlide(index) {

  setJumbotronImage( preloadedImages[currIndex] );
  setHeader( headerTexts[currIndex] );

  var isLink = (currIndex == 1 || currIndex == 2) ? true : false;

  setParagraph( paragraphsTexts[currIndex], isLink );

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
