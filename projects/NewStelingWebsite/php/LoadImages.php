<?php
$files = glob("uploads/*.*");
for ($i=1; $i<4; $i++) {
  $image = $files[$i];
  if ($i % 4 == 0) {
    echo '</div>';
    echo '<div class="row">';
  } else {
    echo '<div class="col-sm">';
    echo '<div class="image-wrapper">';
    echo '<img src="'.$image .'" />';
    echo '</div>';
    echo '</div>';
  }
}
?>
