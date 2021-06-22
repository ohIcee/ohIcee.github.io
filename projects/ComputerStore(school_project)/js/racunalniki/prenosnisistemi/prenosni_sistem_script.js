$(document).ready(function() {
  $('.scrollspy').scrollSpy();
});

var options = [{
  selector: '#features-header',
  offset: 200,
  callback: function(el) {
    setTimeout(function() {
      $(el).css("opacity", "1");
    }, 250);
    setTimeout(function() {
      $("#first-feature").css("opacity", "1");
    }, 500);
    setTimeout(function() {
      $("#second-feature").css("opacity", "1");
    }, 750);
    setTimeout(function() {
      $("#third-feature").css("opacity", "1");
    }, 1000);
  }
}, {
  selector: '#tech-specs .section-header',
  offset: 200,
  callback: function(el) {
    $(el).css("opacity", "1");
    $("table").css("opacity", "1");
  }
}, {
  selector: '#video .section-header',
  offset: 200,
  callback: function(el) {
    $(el).css("opacity", "1");
    $("iframe").css("opacity", "1");
  }
}];


Materialize.scrollFire(options);
