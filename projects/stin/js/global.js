$('.ui.sidebar').sidebar('attach events', '#mobile_item');

$(window).scroll(function (event) {

  var scroll = $(window).scrollTop();

  if (scroll > 0) {
    $(".nav-background").addClass("nav-bg-expand");
    $(".nav-background.nav-bg-mobile").addClass("nav-bg-expand");
    $("#mobile_item i").addClass("mobile-menu-icon-black");
  } else if (scroll < 50) {
    $(".nav-background").removeClass("nav-bg-expand");
    $(".nav-background.nav-bg-mobile").removeClass("nav-bg-expand");
    $("#mobile_item i").removeClass("mobile-menu-icon-black");
  }
});

$("#mobile-nav-logo").click(function() {
  window.location.href = "index.php";
});

function getPageName() {
    var index = window.location.href.lastIndexOf("/") + 1,
        filenameWithExtension = window.location.href.substr(index),
        filename = filenameWithExtension.split(".")[0];

    return filename;
}
