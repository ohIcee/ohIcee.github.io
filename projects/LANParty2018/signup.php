<!--










`,,,,,,,,,,     `,,,,,,,,,. ,,,,,,,,,,,,,,,,,,.   ,,,,,,,,,,,,,,,,,,..,,,,,,,,,,,,,,,,,,,,,,,.
`@########W     +#########i n#################*   x#################ii#######################*
z#########.    n#########. n#################*   x#################ii#######################*
i#########;    W########x  n#################*   x#################ii#######################*
`#########+   .#########*  n#################*   x#################ii#######################*
x########n   ;#########,  n#################*   x#################ii#######################*
*########M   #########M   n#################*   x#################ii#######################*
,########@`  x########+   n#################*   x#################ii#######################*
M########: `@########,   n##########xxxxxxx;   x##########xxxxxxx;;xxxxxx###########xxxxxx;
#########i ,########W    n##########:          x##########,              @#########@`
:######### i#########    n##########,          x##########,              @#########@
`W#######x #########:    n##########,          x##########,              @#########@
z#######W x#######@`    n##########,          x##########,              @#########@
;########.@#######z     n##########,          x##########,              @#########@
`@#######;########;     n##########,          x##########,              @#########@
x#######z#######@`     n##########,          x##########,              @#########@
*#######@#######n      n##########nzzzzzz`   x##########nzzzzzz        @#########@
.###############i      n################@`   x################@        @#########@
M#############@.      n################@`   x################@        @#########@
+#############x       n################@`   x################@        @#########@
:#############*       n################@`   x################@        @#########@
`W############.       n################@`   x################@        @#########@
z###########M        n################@`   x################@        @#########@
;###########+        n##########@@@@@@W`   x##########@@@@@@W        @#########@
`@##########,        n##########:``````    x##########,``````        @#########@
n#########W         n##########,          x##########,              @#########@
+#########z         n##########,          x##########,              @#########@
+#########z         n##########,          x##########,              @#########@
+#########z         n##########,          x##########,              @#########@
+#########z         n##########,          x##########,              @#########@
+#########z         n##########,          x##########,              @#########@
+#########z         n##########,          x##########,              @#########@
+#########z         n##########i:::::::`  x##########;:::::::`      @#########@
+#########z         n##################,  x##################,      @#########@
+#########z         n##################,  x##################,      @#########@
+#########z         n##################,  x##################,      @#########@
+#########z         n##################,  x##################,      @#########@
+#########z         n##################,  x##################,      @#########@
+#########z         n##################,  x##################,      @#########@
+#########z         n##################,  x##################,      @#########@
innnnnnnnn*         +nnnnnnnnnnnnnnnnnn,  +nnnnnnnnnnnnnnnnnn.      znnnnnnnnnn



KA PA GLEDAŠ V KODO ADIJO DA TE NE VIDIM VEČ
aja pa če hoč kak aram kda addi byicee na lol tho






-->

<?php

// // TODO:
// ERROR CHECK

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('php/DBConnect.php');

if (!isset($_GET['selectedgame'])) {
  echo "invalid selection";
  exit();
}
$SelectedGame = $_GET['selectedgame'];
$SelectedGameContact = $SelectedGame == 'league' ? 'Summoner Name' : 'Steam Profil [Link]';

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Prijava - SŠRavne Lan Party 2018</title>

    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.16/css/uikit.min.css" />
    <link rel="stylesheet" href="css/signup_design.css?v=2.1">
  </head>
  <body>

    <div id="site-wrapper" class="uk-flex uk-flex-column uk-flex-middle uk-flex-center uk-text-center uk-container uk-container-large uk-child-width-expand">

      <h1 id="title">LAN Party 2018</h1>
      <h4 id="sec-title">Srednja Šola Ravne na Koroškem</h4>

      <hr>

      <div id="error-alert" class="uk-alert-danger" uk-alert>
        <p></p>
      </div>

      <div class="uk-child-width-expand@l uk-grid-divider" uk-grid>
        <div class="uk-child-width-3-4" id="signup-section">
          <?php if (!isset($_GET['signupSuccess'])) { ?>
          <div class="uk-margin">
            <caption>Prijava ekipe</caption>
          </div>
          <fieldset class="uk-fieldset">

          <div id="team-info" style="width: 100%" class="uk-child-width-1-2@s uk-text-center uk-grid-collapse" uk-grid>
            <div class="uk-width-expand uk-inline">
              <span class="uk-form-icon" uk-icon="icon: users"></span>
              <input class="uk-input" name="teamname" maxlength="15" type="text" placeholder="Ime Ekipe" required>
            </div>
            <div class="uk-width-expand uk-inline">
              <span class="uk-form-icon" uk-icon="icon: hashtag"></span>
              <input class="uk-input" name="teamtag" maxlength="4" type="text" placeholder="Kratica (Clan Tag)" required>
            </div>
          </div>

          <div class="uk-margin"></div>

          <div id="team-members-input">
            <!--<p>Player 1</p>-->
            <div class="uk-margin">
              <label class="uk-form-label" for="form-stacked-text">Player 1</label>
              <div class="uk-form-controls">
                <div class="uk-text-center uk-width-expand uk-grid-collapse uk-child-width-expand@s" uk-grid>
                  <div class="uk-inline">
                    <span class="uk-form-icon" uk-icon="icon: user"></span>
                    <input name="p1-fullname" class="uk-input" type="text" placeholder="Ime in Priimek" required>
                  </div>
                  <div class="uk-inline">
                    <span class="uk-form-icon" uk-icon="icon: more-vertical"></span>
                    <input name="p1-school" class="uk-width-expand uk-input" type="text" placeholder="Šola" required>
                  </div>
                  <div class="uk-inline">
                    <span class="uk-form-icon" uk-icon="icon: mail"></span>
                    <input name="p1-email" class="uk-width-expand uk-input" type="text" placeholder="E-Mail" required>
                  </div>
                </div>
              </div>
            </div>

            <!--<p>Player 2</p>-->
            <div class="uk-margin">
              <label class="uk-form-label" for="form-stacked-text">Player 2</label>
              <div class="uk-form-controls">
                <div class="uk-text-center uk-width-expand uk-grid-collapse uk-child-width-expand@s" uk-grid>
                  <div class="uk-inline">
                    <span class="uk-form-icon" uk-icon="icon: user"></span>
                    <input name="p2-fullname" class="uk-input" type="text" placeholder="Ime in Priimek" required>
                  </div>
                  <div class="uk-inline">
                    <span class="uk-form-icon" uk-icon="icon: more-vertical"></span>
                    <input name="p2-school" class="uk-width-expand uk-input" type="text" placeholder="Šola" required>
                  </div>
                </div>
              </div>
            </div>

            <!--<p>Player 3</p>-->
            <div class="uk-margin">
              <label class="uk-form-label" for="form-stacked-text">Player 3</label>
              <div class="uk-form-controls">
                <div class="uk-text-center uk-width-expand uk-grid-collapse uk-child-width-expand@s" uk-grid>
                  <div class="uk-inline">
                    <span class="uk-form-icon" uk-icon="icon: user"></span>
                    <input name="p3-fullname" class="uk-input" type="text" placeholder="Ime in Priimek" required>
                  </div>
                  <div class="uk-inline">
                    <span class="uk-form-icon" uk-icon="icon: more-vertical"></span>
                    <input name="p3-school" class="uk-width-expand uk-input" type="text" placeholder="Šola" required>
                  </div>
                </div>
              </div>
            </div>

            <!--<p>Player 4</p>-->
            <div class="uk-margin">
              <label class="uk-form-label" for="form-stacked-text">Player 4</label>
              <div class="uk-form-controls">
                <div class="uk-text-center uk-width-expand uk-grid-collapse uk-child-width-expand@s" uk-grid>
                  <div class="uk-inline">
                    <span class="uk-form-icon" uk-icon="icon: user"></span>
                    <input name="p4-fullname" class="uk-input" type="text" placeholder="Ime in Priimek" required>
                  </div>
                  <div class="uk-inline">
                    <span class="uk-form-icon" uk-icon="icon: more-vertical"></span>
                    <input name="p4-school" class="uk-width-expand uk-input" type="text" placeholder="Šola" required>
                  </div>
                </div>
              </div>
            </div>

            <!--<p>Player 5</p>-->
            <div class="uk-margin">
              <label class="uk-form-label" for="form-stacked-text">Player 5</label>
              <div class="uk-form-controls">
                <div class="uk-text-center uk-width-expand uk-grid-collapse uk-child-width-expand@s" uk-grid>
                  <div class="uk-inline">
                    <span class="uk-form-icon" uk-icon="icon: user"></span>
                    <input name="p5-fullname" class="uk-input" type="text" placeholder="Ime in Priimek" required>
                  </div>
                  <div class="uk-inline">
                    <span class="uk-form-icon" uk-icon="icon: more-vertical"></span>
                    <input name="p5-school" class="uk-width-expand uk-input" type="text" placeholder="Šola" required>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
            <p class="uk-text-primary">Z prijavo ekipe se soglašate s pravili:</p>
          </div>
          <div class="uk-margin uk-grid-small uk-text-left">
            <?php if ($SelectedGame == "csgo") echo '<p><span uk-icon="icon: triangle-right"></span>Vsak igralec ima po potrebi pripravljen Config File</p>'; ?>
            <div class="uk-alert-primary" uk-alert>
              <p><span uk-icon="icon: triangle-right"></span> Od 14:00 do 15:00 je check-in za ekipe na lokaciji LAN Partija.</p>
              <p><span uk-icon="icon: triangle-right"></span> Za vprašanja kontaktirajte <a href="mailto:0timmori0@gmail.com">0timmori0@gmail.com</a></p>
            </div>
            <p><span uk-icon="icon: triangle-right"></span> Goljufanje pomeni diskvalifikacija ekipe</p>
            <p><span uk-icon="icon: triangle-right"></span> Priporočena uporaba svoje opreme (Brez računalnika, monitorja)</p>
            <p><span uk-icon="icon: triangle-right"></span> Čas namestitve opreme pred igro je 15 minut.</p>
            <p><span uk-icon="icon: triangle-right"></span> Igrajo lahko samo dijaki/-nje.</p>
          </div>

          <button onclick="ProcessSignup(this)" class="uk-button uk-button-default uk-button-primary uk-width-1-1 uk-button-large uk-margin">
            <span class="enabled-text">Prijavi se!</span>
            <span class="disabled-text"><div uk-spinner></div></span>
          </button>

          </fieldset>
        <?php } else { ?>
          <div class="uk-alert-primary" uk-alert>
            <p>Prijava Uspešna!</p>
          </div>
        <?php } ?>
        </div>

        <div id="registered-section">
          <div class="uk-margin">
            <caption>Registrirane ekipe</caption>
          </div>
          <table id="registered-teams-table" class="uk-table uk-table-striped">
            <tbody>
              <?php
              $sql = "SELECT name FROM teams WHERE game=:game";
              $stmt = $db->prepare($sql);
              $stmt->bindValue(':game', $SelectedGame);
              $result = $stmt->execute();
              $row = $stmt->fetchAll();
              foreach ($row as $key) {
                echo ''
                . '<tr>'
                  . '<td>' . $key['name'] . '</td>'
                . '</tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

      <h1 id="title">Bracketi</h1>
      <p id="sec-title">(Naključno bodo generirani na dan dogodka)</p>
      <?php if ($SelectedGame == 'csgo') { ?>
      <iframe src="https://challonge.com/lanravnecs/module" width="100%" height="500" frameborder="0" scrolling="auto" allowtransparency="true"></iframe>
      <?php } else { ?>
      <iframe src="https://challonge.com/lanravnelol/module" width="100%" height="500" frameborder="0" scrolling="auto" allowtransparency="true"></iframe>
      <?php } ?>

    </div>

    <!--<script src="js/jquery_ajax.js" charset="utf-8"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.16/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.16/js/uikit-icons.min.js"></script>
    <script src="js/signup_script.min.js" charset="utf-8"></script>
  </body>
</html>
