<?php
global $base_url;
$theme_path = $base_url . '/sites/all/themes/local_fixer';
//pa($theme_path);
?>
<!--<div id="slide-panel" style="top:230px">-->
<div id="slide-panel">
  <a href="#" class="" id="opener"><img src="<?php print($theme_path) ?>/images/feedback-btn.jpg" alt=""></a>
  <div class="feedback-form text-center">
    <?php
    print($content);
    ?>
  </div>
</div>
