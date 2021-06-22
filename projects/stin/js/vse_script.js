$(document).ready(function() {
  parseImages();
  createClickableCards();
	checkWindowSize();

  if (getUrlParameter('novica') !== undefined) {
    scrollToNovica(getUrlParameter('novica'));
  }
});

$(window).on('resize', function() {
  checkWindowSize();
});

function scrollToNovica(novicaID) {
  $(document).scrollTop( $(".anchor#" + novicaID).offset().top );
  $( $(".ui.vertical.segment." + novicaID) ).addClass("highlight");
}

function checkWindowSize() {
  var win = $(this);
	if (win.width() > 1200) {
		$('.ui.left.floated.image').addClass("large");
		$('.ui.left.floated.image').removeClass("medium");
	} else {
		$('.ui.left.floated.image').removeClass("large");
		$('.ui.left.floated.image').addClass("medium");
	}
}

function parseImages() {

  var imagesToParse = $(".postImg");

  $.each(imagesToParse, function(index, value) {
    var imgName = $(this).attr('imgname');
    var pageType = getUrlParameter('type');

    var typeUploadsUrl = pageType == 'reference' ? 'reference' : 'novice';

    $(this).css('background-image', 'url("uploads/'+typeUploadsUrl+'/'+imgName+'")');
    $(this).removeAttr('imgname');
  });

}

function createClickableCards() {
  var cards = $('.card');
  var type = getUrlParameter('type');

  for (var i = 0; i < cards.length; i++) {
    $(cards[i]).click(function() {
      console.log($(this));
      var ct = type == 'novice' ? 'novica.php?id=' : 'referenca.php?id=';
      window.location.href = ct + $(this).attr('id');
    });
  }
}

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};
