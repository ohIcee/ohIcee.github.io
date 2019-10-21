var menu_button = document.getElementsByClassName("menu")[0];
var mobile_menu = document.getElementsByClassName("mobile-menu-overlay")[0];
var nav = document.querySelector('nav');
var body = document.querySelector('body');

function menu_toggle() {
    
    body.classList.contains('noscroll')
        ? body.classList.remove('noscroll')
        : body.classList.add('noscroll');

    mobile_menu.classList.contains('show-mobile-menu')
        ? mobile_menu.classList.remove('show-mobile-menu')
        : mobile_menu.classList.add('show-mobile-menu');

    nav.classList.contains('nav-nobg')
        ? nav.classList.remove('nav-nobg')
        : nav.classList.add('nav-nobg');

    if (mobile_menu.classList.contains('show-mobile-menu')) {
        scrollTo('#welcome');
    }

}

function menu_item(i, _toggle_menu) {

    if (_toggle_menu) {
        menu_toggle();
    }

    switch(i) {
        case 'home':
            scrollTo('#');
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