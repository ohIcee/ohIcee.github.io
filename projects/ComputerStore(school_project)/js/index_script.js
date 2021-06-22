$(document).ready(function() {

  assignClickFunctions();

  $('.slider').slider();
  $('.carousel.carousel-slider').carousel({
    fullWidth: true
  });
  $(".indicator-item").addClass('waves-effect waves-light');


  var multipleItems = $('.multiple-items');
  multipleItems.slick({
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 3,
    responsive: [{
        breakpoint: 1200,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      }, {
        breakpoint: 450,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }

    ]
  });

});

function assignClickFunctions() {

  $("#macbookair").click(function() {
    window.location.href = "racunalniki/PrenosniSistemi/macbookair.html";
  });

  $("#razerbladepro").click(function() {
    window.location.href = "racunalniki/PrenosniSistemi/razerbladepro.html";
  });

  $("#spectre").click(function() {
    window.location.href = "racunalniki/PrenosniSistemi/hpspectrex360.html";
  });

  $("#gpixel").click(function() {
    window.location.href = "racunalniki/PrenosniSistemi/pixelbook.html";
  });

  $("#miair").click(function() {
    window.location.href =
      "racunalniki/PrenosniSistemi/xiaominotebookair.html";
  });

  $("#xps15").click(function() {
    window.location.href = "racunalniki/PrenosniSistemi/dellxps15.html";
  });

  $("#8700").click(function() {
    window.location.href = "komponente/Komponente/intel8700.html";
  });

  $("#8400").click(function() {
    window.location.href = "komponente/Komponente/intel8400.html";
  });

  $("#1800x").click(function() {
    window.location.href = "komponente/Komponente/ryzen1800x.html";
  });

  $("#ssd").click(function() {
    window.location.href = "komponente/Komponente/samsungssd.html";
  });

  $("#gskill").click(function() {
    window.location.href = "komponente/Komponente/gskill.html";
  });

  $("#1080ti").click(function() {
    window.location.href = "komponente/Komponente/GTX1080Ti.html";
  });

}
