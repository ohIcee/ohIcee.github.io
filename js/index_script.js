function openMail() {
    var mail = "icevx1@gmail.com";

    window.location.href =
    "mailto:"+mail+"?subject=Subject&body=Enter%20your%20message.";
}

function openGithub() {
  var githubLink = "https://github.com/ohicee";

  window.open(githubLink, "_blank");
}

particlesJS.load('particles-js', 'assets/particlesjs-config.json', function() {
    console.log('callback - particles.js config loaded');
});

document.body.addEventListener('click', function(e){
    var target = e.target;
    if(target.classList.contains('cv-redirect')) {
        document.getElementById("cv-overlay").classList.add('transition-to-cv');
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

        if (name == "faceit_stats") {
          // window.open("https://play.google.com/store/apps/details?id=com.potatocouch.faceit_stats", "_blank");
          window.open("https://github.com/ohIcee/faceit_stats_mobile", "_blank");
          return;
        }

        if (name == "NetYeet") {
            window.open("https://github.com/ohIcee/NetYeet", "_blank");
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

let params = new URLSearchParams(location.search);
if (params.get('sender') != null) {
    window.history.replaceState({}, document.title, "/" + "index.html");
    document.getElementById('cv-overlay').classList.add('transition-from-cv');
}
