var nav = document.querySelector('nav');
var logo = document.getElementsByClassName('logo')[0];
var menu_toggle_btn = document.getElementById('mobile-nav-toggle');

var scrolledNavHeight = '80px';
var defaultNavHeight = nav.style.height;

window.onscroll = function() {

  var currentScrollPos = window.pageYOffset;

  if (currentScrollPos < 10) {
    nav.style.height = defaultNavHeight;
    logo.style.lineHeight = defaultNavHeight;
    menu_toggle_btn.style.lineHeight = defaultNavHeight;
  } else {
    nav.style.height = scrolledNavHeight;
    logo.style.lineHeight = scrolledNavHeight;
    menu_toggle_btn.style.lineHeight = scrolledNavHeight;
  }

}

function scrollTo(anchor) {
  document.querySelector(anchor).scrollIntoView({
    behavior: 'smooth'
  });
}