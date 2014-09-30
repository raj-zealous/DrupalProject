<?php
/**
 * @file
 * Bartik's theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode; for example, "full", "teaser".
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined; for example, $node->body becomes $body. When needing to
 * access a field's raw values, developers/themers are strongly encouraged to
 * use these variables. Otherwise they will have to explicitly specify the
 * desired field language; for example, $node->body['en'], thus overriding any
 * language negotiation rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */
 

global $base_url;
global $user;
$path = $base_url . '/' . path_to_theme();

$user_info = user_load($node->uid);

$field_review_location_field = field_get_items("node", $node, "field_review_location");
$field_review_location_value = field_view_value("node", $node, "field_review_location", $field_review_location_field[0]);
$field_review_street_no_field = field_get_items("node", $node, "field_review_street_no");
$field_review_street_no_value = field_view_value("node", $node, "field_review_street_no", $field_review_street_no_field[0]);
$field_review_street_field = field_get_items("node", $node, "field_review_street");
$field_review_street_value = field_view_value("node", $node, "field_review_street", $field_review_street_field[0]);
$field_review_city_field = field_get_items("node", $node, "field_review_city");
$field_review_city_value = field_view_value("node", $node, "field_review_city", $field_review_city_field[0]);
$field_review_state_field = field_get_items("node", $node, "field_review_state");
$field_review_state_value = field_view_value("node", $node, "field_review_state", $field_review_state_field[0]);
$field_review_country_field = field_get_items("node", $node, "field_review_country");
$field_review_country_value = field_view_value("node", $node, "field_review_country", $field_review_country_field[0]);
$field_review_name_of_est_field = field_get_items("node", $node, "field_review_name_of_est");
$field_review_name_of_est_value = field_view_value("node", $node, "field_review_name_of_est", $field_review_name_of_est_field[0]);
$field_review_type_field = field_get_items("node", $node, "field_review_type");
$field_review_type_value = field_view_value("node", $node, "field_review_type", $field_review_type_field[0]);
$field_review_images_field = field_get_items("node", $node, "field_review_images");
$field_review_images_value = field_view_value("node", $node, "field_review_images", $field_review_images_field[0]);
$field_reivew_interest_field = field_get_items("node", $node, "field_reivew_interest");
//$field_reivew_interest_value = field_view_field("node", $node, "field_reivew_interest", $field_reivew_interest_field,"plain");
//echo '<pre>';print_r($field_reivew_interest_field);die;
?>
<script src="<?php print $path; ?>/js/jquery.nicescroll.js"></script>

<script>

  jQuery(document).ready(function() {
    //alert('12');
    jQuery("#custom-scroll").niceScroll("#content-section", {cursorcolor: "#aaaaaa", cursoropacitymax: 1, boxzoom: true, touchbehavior: true});
  });

  function replace_images(image_path) {
    //alert(image_path);
    document.getElementById("main_image").src = image_path;
  }
</script>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <div class="pro-review-box clearfix">
    <div class="review-image-box">
      <div class="image-box"><a href="<?php print $base_url . "/node/" . $node->nid; ?>"><?php print render($field_review_images_value) ?></a></div>

      <div class="review-rating"></div>
    </div>

    <div class="review-right-data">
      <div class="review-heading clearfix">
        <h2><?php print $title; ?></h2>
        <div class="right-header">
          <?php if ($user->uid != $node->uid) { ?>
            <div class="remove-link"><a href="<?php print $base_url . "/remove_review/" . $node->nid; ?>">Remove</a></div>
          <?php } ?>
          <div class="likebox"><span>90%</span></div>
        </div>
      </div>

      <div class="write-place clearfix">
        <div class="review-place-name"><?php print render($field_review_name_of_est_value); ?></div>
        <div class="review-place-right"><?php print render($field_review_type_value['#title']); ?></div>
      </div>

      <div class="preview-location review">
        <div class="location-text">
          <?php print render($field_review_location_value['#address']['premise']) . ' ' . render($field_review_location_value['#address']['thoroughfare']) . ', '; ?>
          <?php print render($field_review_location_value['#address']['locality']) . ' ' . render($field_review_location_value['#address']['administrative_area']); ?>
          <?php print $field_review_location_value['country']['#options'][$field_review_location_value['#address']['country']]; ?>
        </div>

        <div class="write-text clearfix">
          <p>
            <?php print render($content['field_review_description']); ?>
          </p>
        </div>

        <div class="review-place clearfix">
          <div class="place-title"><?php
            $count = 0;
            foreach ($field_reivew_interest_field as $key => $value) {
              if ($count == 0) {
                print $value['taxonomy_term']->name;
              } else {
                print ", " . $value['taxonomy_term']->name;
              }
              $count++;
            }
            ?></div>
          <div class="review-link"><a href="<?php print $base_url . "/node/" . $node->nid; ?>">Full Review »</a></div>
        </div>
      </div>
    </div>


  </div>





</div>