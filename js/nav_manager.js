var menu_button = document.getElementsByClassName("menu")[0];
var mobile_menu = document.getElementsByClassName("mobile-menu-overlay")[0];
var nav = document.querySelector('nav');
var html = document.querySelector('html');

var is_active = false;

function menu_toggle() {
    
    if (is_active) {
        html.classList.remove('noscroll');
        mobile_menu.classList.remove('show-mobile-menu');
        menu_button.classList.remove('is-active');
        nav.classList.remove('nav-nobg');
    } else {
        html.classList.add('noscroll');
        mobile_menu.classList.add('show-mobile-menu');
        menu_button.classList.add('is-active');
        nav.classList.add('nav-nobg');
    }

    is_active = !is_active;

}

function menu_item(i, _toggle_menu) {

    if (_toggle_menu) {
        menu_toggle();
    }

    switch(i) {
        case 'home':
            scrollTo('#welcome');
            break;
        case 'cv':
            break;
        case 'projects':
            scrollTo('#projects-anchor');
            break;
        case 'contact':
            scrollTo('#contact');
            break;
    }

}

// Hide mobile menu if window resized
// further than mobile size
var onresize = function() {
    width = document.body.clientWidth;

    if (width > 885 && is_active) {
        menu_toggle();
    }
}
window.addEventListener("resize", onresize);