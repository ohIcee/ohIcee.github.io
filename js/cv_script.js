document.body.addEventListener('click', function(e){
    var target = e.target;
    if(target.classList.contains('home')) {
        document.getElementById("file-mockup").classList.add('hide-mockup');
        document.getElementsByTagName("body")[0].classList.add('disable-overflow');
        setTimeout(function() {
            if(target.dataset) window.location = target.dataset.redirect;
            else window.location = target.getAttribute('data-redirect');
            }, 850);
    }
}, false);