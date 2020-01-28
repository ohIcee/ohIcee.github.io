function openMail() {
    var mail = "icevx1@gmail.com";

    window.location.href = 
    "mailto:"+mail+"?subject=Subject&body=Enter%20your%20message.";
}

particlesJS.load('particles-js', 'assets/particlesjs-config.json', function() {
    console.log('callback - particles.js config loaded');
});

document.body.addEventListener('click', function(e){
    var target = e.target;
    if(target.classList.contains('cv-redirect')) {
        document.getElementById("cv-overlay").classList.add('cv-transition');
        document.getElementsByTagName("body")[0].classList.add('disable-overflow');
        setTimeout(function() {
            if(target.dataset) window.location = target.dataset.redirect;
            else window.location = target.getAttribute('data-redirect');
            }, 500);
    }
}, false);

var createClickHandler = function(name) {
    return function() { 

        if (name == "StelingWebsite") {
            window.open("http://steling.si/", "_blank");
            return;
        }

        if (name == "stin") {
            window.open("https://www.stin.si/", "_blank");
            return;
        }

        window.open("/projects/"+name, "_blank");
    };
}

var projects = document.getElementsByClassName("project");
for(var i = 0; i < projects.length; i++)
{
   var projName = projects[i].id;

   projects[i].onclick = createClickHandler(projName);
}