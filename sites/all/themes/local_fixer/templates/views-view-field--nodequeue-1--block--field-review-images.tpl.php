<?php
/**
 * @file
 * This template is used to print a single field in a view.
 *
 * It is not actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the template is
 * perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */
global $base_url;
global $user;
$path = $base_url . '/' . path_to_theme();
?>
<div class="topfixer-image">
  <?php print $output; ?>
  <?php if (user_is_logged_in()) { ?>
    <div class="save-icon">
      <a href="<?php print $base_url . "/save_review/" . $row->nid ?>"><img src="<?php print $path; ?>/images/save-image-icon.png" alt=""></a>
    </div>
  <?php } else { ?>
    <div class="save-icon">
      <a href="javascript:void()" onclick="document.getElementById('register_link').click();"><img src="<?php print $path; ?>/images/save-image-icon.png" alt=""></a>
    </div>

  <?php } ?>
</div>

