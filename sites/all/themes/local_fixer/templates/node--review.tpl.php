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
//echo '<pre>';print_r();die;
global $base_url;
global $user;
$path = $base_url . '/' . path_to_theme();

$user_info = user_load($node->uid);
//echo '<pre>';print_r($user_info);die;
$review_saved = 0;

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
$field_review_users_saved_review_field = field_get_items("node", $node, "field_review_users_saved_review");
if (!empty($field_review_users_saved_review_field)) {
  foreach ($field_review_users_saved_review_field as $key => $value) {

    if ($value['target_id'] == $user->uid) {
      $review_saved = 1;
      break;
    }
  }
}

$count_percentage = count_percentage($node->nid);
$count_user_percentage = count_user_percentage($node->uid);


//pa($count_user_percentage);

$total_messages = count($count_percentage);

if (isset($count_percentage) && !empty($count_percentage)) {
  $cnt = 0;
  $percentage = 0;
  foreach ($count_percentage as $k => $v) {
    if ($v->tag == 'like') {
      $arr_like['like'][$cnt] = 1;
    } else {
      $arr_like['dislike'][$cnt] = 1;
    }
    $cnt++;
  }
  $like_cnt = count($arr_like['like']);
  $unlike_cnt = count($arr_like['unlike']);

  $percentage = ceil(( $like_cnt * 100 ) / $total_messages);
  if ($percentage == '' || $percentage < 0) {
    $percentage = 0;
  }
  //pa($percentag);
}

//echo '<pre>';print_r($node);die;
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
<?php
$like_css = $base_url . '/' . drupal_get_path('theme', 'local_fixer') . '/css/' . 'likebtn.css';
?>
<style src="<?php print $like_css ?>" type="text/css" media="screen" /></style>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <div class="fullpreview-top-box">
    <div class="container">
      <div class="row clearfix">
        <div class="col-sm-12" >
          <div class="fullpreview-contentbox clearfix">
            <div class="fullpreview-leftbox">
              <div class="left-navigation">
                <ul>
                  <?php if ($review_saved == 0 && $user->uid != $node->uid) { ?>
                    <li class="">
                      <a href="<?php print $base_url . "/save_review/" . $node->nid; ?>">
                        <img src="<?php print $path; ?>/images/save-review.png" alt="">
                      </a>
                    </li>
                  <?php } else { ?>
                    <li class=""><a href="#"><img src="<?php print $path; ?>/images/save-review.png" alt=""></a></li>
                  <?php } ?>
                  <li class="">
                    <a href="<?php print $base_url . "/node/add/review?est=" . render($field_review_name_of_est_value); ?>">
                      <img src="<?php print $path; ?>/images/write-review.png" alt="">
                    </a>
                  </li>
                  <?php if ($user->uid != $node->uid) { ?>
                    <li class=""><a href="<?php print $base_url ?>/send_message_to_friend/add/<?php print $uid; ?>/<?php print $title; ?>"><img src="<?php print $path; ?>/images/contact-review.png" alt=""></a></li>	
                  <?php } else { ?>
                    <li class=""><a href="#"><img src="<?php print $path; ?>/images/contact-review.png" alt=""></a></li>	
                  <?php } ?>

                </ul>
              </div>
            </div>
            <div class="fullpreview-rightbox clearfix">
              <div class="gallery-section">

                <div class="gallery-big-image">
                  <?php
                  $all_images = $node->field_review_images['und'];
                  $latest_img = file_create_url($all_images[0]['uri']);
                  if (isset($latest_img) && $latest_img != '') {
                    ?>
                    <img id="main_image" src="<?php print $latest_img; ?>" width="486" height="431" alt="" class="img-responsive">
                  <?php } ?>
                </div>
                <div class="gallery-thumbnails clearfix">
                  <ul>
                    <?php
                    $cnt = 0;
                    foreach ($all_images as $a => $b) {
                      $sub_images = file_create_url($b['uri']);
                      ?>
                      <li><a href="javascript:void(0)" onclick="replace_images('<?php print $sub_images ?>');"><img width="88" height="87" src="<?php print $sub_images; ?>" alt="" class="img-responsive"></a></li>
                      <?php
                    }
                    ?>
                  </ul>
                </div>

                <div class="preview-location text-center">
                  <div class="location-text"> 
                    <?php print render($field_review_location_value['#address']['premise']) . ' ' . render($field_review_location_value['#address']['thoroughfare']) . ', '; ?>
                    <?php print render($field_review_location_value['#address']['locality']) . ' ' . render($field_review_location_value['#address']['administrative_area']); ?>
                    <?php print $field_review_location_value['country']['#options'][$field_review_location_value['#address']['country']]; ?>
                  </div>
                </div>
                <div class="fullpreview-map">
                  <?php print render($content['field_review_location_geofield']); ?>
                </div>

                <div class="post-like-box clearfix">
                  <div class="like-text text-center">
                    <div>IS THIS A GOOD REVIEW?</div>
                    <a href="#">More information</a>
                  </div>

                  <ul class="like-link">
                    <li class="like"><?php print $node->like; ?><?php print $node->dislike; ?></li>
                  </ul>
                </div>
              </div>

              <div class="profile-user-section ">
                <div class="title-box clearfix">
                  <div class="place-name"><?php print $title; ?></div>
                  <div class="place-rating">
                    <ul class="rating">
                      <?php print render($content['field_review_ratings']); ?>
                    </ul>
                  </div>
                  <div class="clear"></div>
                  <div class="sub-title clearfix"><?php print render($field_review_name_of_est_value); ?><span><?php print render($field_review_type_value['#title']); ?></span></div> 

                </div>

                <div class="userinfo-box clearfix">
                  <div class="user-image">
                    <a href="<?php print $base_url . "/user/" . $node->uid ?>"><?php print $user_picture; ?></a>
                  </div>
                  <div class="user-info">Review by <a href="<?php print $base_url . "/user/" . $node->uid ?>" class="user-name"><?php print $user_info->name; ?></a> 
                    <span>
                      <?php
                      if (trim($count_user_percentage) != "") {
                        print $count_user_percentage;
                      } else {
                        print "0";
                      }
                      ?>%
                    </span> on <?php print date('F d, Y', $node->created); ?> </div>

                  <div class="like-ratingbox">
                    <div class="like-total"><?php
                      if (trim($percentage) != "") {
                        print $percentage;
                      } else {
                        print "0";
                      }
                      ?>%</div>
                  </div>
                </div>

                <div class="user-content" id="custom-scroll">
                  <div id="content-section">
                    <p>
                      <?php print render($content['field_review_description']); ?>
                    </p>
                  </div>
                </div>

                <div class="social-box">
                  <div class="travel-exp">
                    <div class="a2a_kit">
                      <ul>
                        <li class="facebook"><a class="a2a_button_facebook pf-fb"></a></li>
                        <li class="twitter"><a class="a2a_button_twitter pf-twitter"></a></li>
                        <li class="google"><a class="a2a_button_google_plus pf-gplus"></a></li>
                        <li><a class="a2a_button_facebook_like" data-href="<?php print $base_url . "/node/" . $node->nid; ?>" data-layout="standard" data-show-faces="true" data-width="450"></a></li>
                      </ul>
                    </div>
                  </div>

                  <script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>
                </div>
              </div>
            </div>

          </div>

          <div class="back-link"><a href="<?php print $base_url . "/search-reviews" ?>">Back to Search</a></div>

        </div>
      </div>
    </div>

  </div>
  <?php
  print render($content['comments']);
  ?>
</div>