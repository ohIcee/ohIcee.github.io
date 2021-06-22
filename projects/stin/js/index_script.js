$('.ui.accordion')
  .accordion();

$("#more-company-info-button").click(() => toggleExtendedCompanyInfo(true));
$("#less-company-info-button").click(() => toggleExtendedCompanyInfo(false));
$("#about-company-nav").click(() => toggleExtendedCompanyInfo(true));
$("#mobile-about-cpmn").click(function() {
  toggleExtendedCompanyInfo(true);
  $('.ui.sidebar').sidebar('toggle');
});
$("#mobile-cntc").click(function() {
  $('.ui.sidebar').sidebar('toggle');
});

$("#more-contact-info-button").click(function() {
  showMoreContactInfo();
});

$(document).ready(function() {
  getAnchor();
  parseImages();
});

function parseImages() {

  var ref_imagesToParse = $(".ui.items.reference .ui.small.image");
  var nov_imagesToParse = $(".ui.items.novice .ui.small.image")

  $.each(ref_imagesToParse, function(index, value) {
    var imgName = $(this).attr('imgname');
    $(this).css('background-image', 'url("uploads/reference/'+imgName+'")');
    $(this).removeAttr('imgname');
  });

  $.each(nov_imagesToParse, function(index, value) {
    var imgName = $(this).attr('imgname');
    $(this).css('background-image', 'url("uploads/novice/'+imgName+'")');
    $(this).removeAttr('imgname');
  });

}

function getAnchor() {
  var hash = $(location).attr('hash');
  if (hash == "#kontakt-anchor") {
    showMoreContactInfo();
  } else if (hash == "#opodjetju-anchor") {
    toggleExtendedCompanyInfo(true);
  }
}

function showMoreContactInfo() {
  $("#more-contact-info-button").hide();
  $("#company-details").show("fade", 1000);
}

function toggleExtendedCompanyInfo(show) {
  if (show) {
    $("#more-company-info-button").hide();
    $("#more-about").show("fade", 500);
  } else {
    $("#more-company-info-button").show();
    $("#more-about").hide();

    $(document).scrollTop( $("#opodjetju-anchor").offset().top );
  }
}

$(window).scroll(function (event) {

    var scroll = $(window).scrollTop();

    if (scroll > 0) {
      $(".right.menu").addClass("nav-items-black");

      $("#nav-logo").attr('src', 'res/logo-2_optimized-248x100.png');
      $("#mobile-navbar img").attr('src', 'res/logo-2_optimized-248x100.png');
    } else if (scroll < 50) {
      $(".right.menu").removeClass("nav-items-black");

      $("#nav-logo").attr('src', 'res/logo-2-white-shadow_optimized-248x100.png?v=1.0.png');
      $("#mobile-navbar img").attr('src', 'res/logo-2-white-shadow_optimized-248x100.png?v=1.0.png');
    }
});
