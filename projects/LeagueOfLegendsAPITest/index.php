<head>

  <title>LOL_API_TEST</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/index_design.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">


</head>
<body style="font-family: Arial;">

  <div class="outer">
    <div class="middle">
      <div class="inner">

      <p class="TitleText">RIOT_API_TEST<span style="font-size: 15px">Rito updated their API Gateways so this doesn't work anymore</span></p>


      <nav style="background-color: #3498db; min-width: 50px; max-width: 1000px; margin: auto">
        <div>
          <div class="nav-wrapper" style="background-color: #3498db;">
            <!--<form method="post" >-->
              <div class="input-field">
                <input class="search" id="search" type="search" placeholder="SEARCH EUW" name="search" on required>
              </div>
            <!--</form>-->
          </div>
        </div>
      </nav>

    </div>
  </div>
</div>

<script>

$(document).ready(function() {

  if(localStorage.getItem("currRegion") == null) {
    localStorage.setItem("currRegion", "EUW");
  }
  var currRegion = localStorage.getItem("currRegion");

  document.getElementById('search').placeholder= "SEARCH " + currRegion;

});

function refreshByInput(){

  var y = $(".search").val();

    $.ajax({
      type: 'POST',
      url: 'php/refreshSummoner.php',
      data: {
        summNameInput: y,
      },
      success: function(response) {
        $(document.body).fadeOut(1000).delay(10000);
        window.location.replace('Summoner.php');
      }
    });

}

$(document).keypress(function (e) {
    if (e.which == 13 || event.keyCode == 13) {
        refreshByInput();
    }
});

</script>

</body>
