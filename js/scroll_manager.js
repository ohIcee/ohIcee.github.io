var nav = document.querySelector('nav');
var logo = document.getElementsByClassName('logo')[0];
var menu_toggle = document.getElementsByClassName('menu')[0];

var scrolledNavHeight = '80px';
var defaultNavHeight = nav.style.height;

window.onscroll = function() {
  var currentScrollPos = window.pageYOffset;
  if (currentScrollPos < 10) {
    nav.style.height = defaultNavHeight;
    this.logo.style.lineHeight = this.defaultNavHeight;
    this.menu_toggle.style.lineHeight = this.defaultNavHeight;
  } else {
    nav.style.height = scrolledNavHeight;
    this.logo.style.lineHeight = this.scrolledNavHeight;
    this.menu_toggle.style.lineHeight = this.scrolledNavHeight;
  }
}