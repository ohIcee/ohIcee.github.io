function SwitchToAuthenticate(type) {

  if (type == 'register') {
    window.location.href = "authenticate.html";
  }

  if (type == 'login') {

    if ($(window).width() < 767) {
      $("#bgimg").addClass("bgimg-mobile-small");
    }

    $("#nav-buttons").hide();
    $("#auth-buttons").show();
    $("#authenticate-section").slideDown();
  }

}
