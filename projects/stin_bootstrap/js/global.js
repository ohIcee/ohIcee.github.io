$('.ui.sidebar').sidebar('attach events', '#mobile_item');

$(window).scroll(function (event) {

    var scroll = $(window).scrollTop();

    if (scroll > 0) {
      $(".nav-background").addClass("nav-bg-expand");
    } else if (scroll < 50) {
      $(".nav-background").removeClass("nav-bg-expand");
    }
});
