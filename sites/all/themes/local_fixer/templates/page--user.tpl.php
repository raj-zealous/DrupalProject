<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see bootstrap_preprocess_page()
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see bootstrap_process_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 * 
 */
global $base_url;
global $user;

$curr_id = end(explode('/',$_GET['q']));

if($user->uid == '' || !isset($_SESSION['reg_code']) ) {
  drupal_set_message("Login required.", $type = "error");
  header('Location: ' . $base_url);
}

//$user_profile = $page['content']['system_main'];
$args = arg();
$other_user_profile = 0;


if (!empty($args[0]) && $args[0] == 'user' && !empty($args[1])) {
    if ($args[1] == $user->uid) {
        $uid = $args[1];
        $other_user_profile = 0;
    } else {
        $uid = $args[1];
        $other_user_profile = 1;
    }
} else {
    $uid = $user->uid;
    $other_user_profile = 0;
}

$path = $base_url . '/' . path_to_theme();
$user_profile = user_load($uid);

/* code to get default image of User */
$default_pic = variable_get('user_picture_default', $path . '/images/pic.png');
$image_uri = '';
if (!empty($user_profile->picture->uri)) {
    $image_uri = $user_profile->picture->uri;
}

if (($image_uri == "") || ($image_uri == NULL)) {
    $profileImage = $base_url . $default_pic;
} else {
    $profileImage = file_create_url($image_uri);
}



$main_profile = profile2_load_by_user($uid, "main");
$interest_profile = profile2_load_by_user($uid, "your_interest");

$path = $base_url . '/' . path_to_theme();

$field_name_field = field_get_items('profile2', $main_profile, "field_name");
$field_name_value = field_view_value('profile2', $main_profile, "field_name", $field_name_field[0]);

$field_city_field = field_get_items('profile2', $main_profile, "field_city");
$field_city_value = field_view_value('profile2', $main_profile, "field_city", $field_city_field[0]);

$field_country_field = field_get_items('profile2', $main_profile, "field_country");
$field_country_value = field_view_value('profile2', $main_profile, "field_country", $field_country_field[0]);

if (empty($main_profile->field_hide_birth_date)) {
    $field_birth_date_field = field_get_items('profile2', $main_profile, "field_birth_date");
    $birth_date = format_date($field_birth_date_field[0]['value'], "custom", "Y-m-d");
    $from = new DateTime($birth_date);
    $to = new DateTime('today');
    $age = $from->diff($to)->y;
}

if (empty($main_profile->field_hide_gender)) {
    $field_gender_field = field_get_items('profile2', $main_profile, "field_gender");
    if ($field_gender_field[0]['value'] == 'm') {
        
    } else if ($field_gender_field[0]['value'] == 'f') {
        
    }
}

$field_food_field = field_get_items('profile2', $main_profile, "field_food");

$field_drink_field = field_get_items('profile2', $main_profile, "field_drink");

$field_activity_field = field_get_items('profile2', $main_profile, "field_activity");

$field_sleep_field = field_get_items('profile2', $main_profile, "field_sleep");

$field_bio_field = field_get_items('profile2', $main_profile, "field_bio");
$field_bio_value = field_view_value('profile2', $main_profile, "field_bio", $field_bio_field[0]);



$field_interests_field = field_get_items('profile2', $interest_profile, "field_interests");
$title = t('<h3>Interests</h3>');
$type = 'ul';
$attributes = array('class' => 'clearfix'
);
foreach ($field_interests_field as $value) {

    $term = taxonomy_term_load($value['tid']);
    $name = $term->name;
    $items[] = array(
        'data' => '<a href="/search-reviews?field_reivew_interest_tid[]=' . $value['tid'] . '">' . $name . '</a>',
        'id' => $value['tid'], // be careful not to add another id attribute on the page that might be the same as one of the uids or your page will not validate
    );
}
$interest = theme_item_list(array('items' => $items, 'title' => $title, 'type' => $type, 'attributes' => $attributes));
?>
<!------------- HEADER START --------------->


<div class="wrapper">
    <!------------- HEADER START --------------->
    <header class="clearfix">

        <div class="navbar navbar-default" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/"><img src="<?php print $logo; ?>" class="title"></a>
                </div>
                <div class="navbar-collapse collapse">
                    <?php if (!empty($primary_nav) || !empty($secondary_nav) || !empty($page['navigation'])): ?>
                        <div class="navbar-collapse collapse">
                            <nav role="navigation">
                                <?php if (!empty($primary_nav)): ?>
                                    <?php print render($primary_nav); ?>
                                <?php endif; ?>
                                <?php if (!empty($secondary_nav)): ?>
                                    <?php print render($secondary_nav); ?>
                                <?php endif; ?>
                                <?php if (!empty($page['navigation'])): ?>
                                    <?php print render($page['navigation']); ?>
                                <?php endif; ?>
                            </nav>
                        </div>
                    <?php endif; ?>          
                </div><!--/.nav-collapse -->
                <?php if (!empty($page['login_user'])): ?>
                    <?php print render($page['login_user']); ?>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <section id="container-top-bar" class="content-top-bar fullheight">
        <div class="container">
            <div class="row">
                <?php if (!empty($page['highlighted'])): ?>
                    <div class="highlighted jumbotron"><?php print render($page['highlighted']); ?></div>
                <?php endif; ?>        
                <a id="main-content"></a> 
                <?php print $messages; ?>
                <?php if (!empty($action_links)): ?>
                    <ul class="action-links">
                        <?php print render($action_links); ?>
                    </ul>
                <?php endif; ?>

                <div class="white-bg clearfix">
                    <div class="col-sm-5">
                        <div class="profile-leftside clearfix">
                            <div class="profile-leftnav">
                                <ul>
                                    <li class="active"><a href="<?php print $base_url . "/user/" . $uid ?>"><img src="<?php print $path; ?>/images/fixer-info-icon.png" alt=""/></a></li>
                                    <li><a href="<?php print $base_url . "/written-reviews/" . $uid ?>"><img src="<?php print $path; ?>/images/written-reviews-icon.png" alt=""/></a></li>
                                    <li><a href="<?php print $base_url . "/available-accommodation/" . $uid ?>"><img src="<?php print $path; ?>/images/avl-acc-icon.png" alt=""/></a></li>
                                    <li><a href="<?php print $base_url . "/items-to-share/" . $uid ?>"><img src="<?php print $path; ?>/images/item-share-icon.png" alt=""/></a></li>
                                    <?php if($user->uid == $curr_id){ ?>
									<li><a href="<?php print $base_url . "/saved-reviews/" . $uid ?>"><img src="<?php print $path; ?>/images/save-reviews-icon.png" alt=""/></a></li>
									<?php } ?>
                                </ul>
                            </div>
                            <div class="user-profile-box">
                                <div class="profile-user-detail">
                                    <h2><?php print render($field_name_value); ?></h2>
                                    <div class="about-user">
                                        <span><?php print render($field_city_value); ?>, <?php print render($field_country_value); ?></span>
                                        <span class="user-age"><?php print !empty($age) ? $age : ""; ?></span>
                                    </div>
                                </div>
                                <div class="user-rating-box">
                                    <div class="profile-user-pic"><a href="<?php print $base_url . "/user/" . $uid ?>"><img src="<?php print $profileImage ?>" alt=""/></a></div>
                                    <?php
                                    $count_user_percentage = count_user_percentage($uid);
                                    
                                    //pa($node->uid);

                                    ?>
                                    <div class="rating-no">
                                        <h3>User Rating <span><?php
                                                if (trim($count_user_percentage) != "") {
                                                    print $count_user_percentage;
                                                } else {
                                                    print "0";
                                                }
                                                ?>%</span></h3>
                                        <p>Joined <?php print format_date($user_profile->created, "custom", "M d,Y"); ?></p>
                                    </div>
                                    <?php if ($other_user_profile == 1) { ?>
                                        <button class="send-msg" onclick="window.location.href = '<?php print $base_url ?>/send_message_to_friend/add/<?php print $uid; ?>'"><span>Send Message</span></button>                
                                    <?php } else { ?>
                                        <button class="send-msg" onclick="window.location.href = '<?php print $base_url ?>/send_message_to_friend/add'"><span>Send Message</span></button>                              
                                    <?php } ?>
                                </div>
                                <div class="user-interest-box">

                                    <?php print $interest; ?>
                                </div>
                                <div class="share-profile-box clearfix">
                                    <h3>Share this profile</h3>
                                    <div class="a2a_kit">
                                        <ul>
                                            <li><a class="a2a_button_facebook pf-fb"></a></li>
                                            <li><a class="a2a_button_twitter pf-twitter"></a></li>
                                            <li><a class="a2a_button_google_plus pf-gplus"></a></li>
                                            <li><a class="a2a_button_email pf-mail"></a></li>
                                        </ul>
                                    </div>
                                    <script type="text/javascript">
                                        var a2a_config = a2a_config || {};
                                        a2a_config.linkname = '<?php print render($field_name_value); ?>';
                                        a2a_config.linkurl = '<?php print $base_url . "/user/" . $uid ?>';
                                    </script>
                                    <script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>      
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="profile-rgt-box">
                            <div class="profile-tab-heading clearfix">
                                <h2>RECOMMENDED Things to do & SEE</h2>
                                <?php if ($other_user_profile == 0) { ?>
                                    <a href="<?php print $base_url . "/user/" . $uid . "/edit" ?>">Edit Profile</a>
                                <?php } ?>
                            </div>
                            <div id="horizontalTab">
                                <ul class="resp-tabs-list">
                                    <li><span class="food"></span>Food</li>
                                    <li><span class="drink"></span>Drink</li>
                                    <li><span class="act"></span>Activity</li>
                                    <li><span class="sleep"></span>Sleep</li>
                                </ul>
                                <div class="resp-tabs-container">
                                    <div>
                                        <?php foreach ($field_food_field as $key => $value) { ?>
                                            <div class="profile-cat-listing clearfix">
                                                <div class="cat-icon"><img src="<?php print $path; ?>/images/food-gray-icon.png" alt=""/></div>
                                                <div class="cat-text"><?php print $value['value']; ?></div>
                                                <?php
                                                if (check_review_exists($value['value'], $uid) != 0) {
                                                    $nid = check_review_exists($value['value'], $uid);
                                                    ?>
													 <?php if($user->uid == $curr_id){ ?>
                                                    <div class="edit-cat"><a href="<?php print $base_url . "/node/" . $nid . "/edit" ?>" class="orange">Edit Review</a></div>
													<?php } ?>
                                                <?php } else { ?>
                                                     <?php if($user->uid == $curr_id){ ?>
													<div class="edit-cat"><a href="<?php print $base_url . "/node/add/review?est=" . $value['value'] ?>" class="orange">Write Review</a></div>
													<?php } ?>
												<?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div>
                                        <?php foreach ($field_drink_field as $key => $value) { ?>
                                            <div class="profile-cat-listing clearfix">
                                                <div class="cat-icon"><img src="<?php print $path; ?>/images/drinkicon-1.png" alt=""/></div>
                                                <div class="cat-text"><?php print $value['value']; ?></div>
                                                <?php
                                                if (check_review_exists($value['value'], $uid) != 0) {
                                                    $nid = check_review_exists($value['value'], $uid);
                                                    ?>
                                                    <?php if($user->uid == $curr_id){ ?>
													<div class="edit-cat"><a href="<?php print $base_url . "/node/" . $nid . "/edit" ?>" class="orange">Edit Review</a></div>
													<?php } ?>
                                                <?php } else { ?>
												<?php if($user->uid == $curr_id){ ?>
                                                    <div class="edit-cat"><a href="<?php print $base_url . "/node/add/review?est=" . $value['value'] ?>" class="orange">Write Review</a></div>
													<?php } ?>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div>
                                        <?php foreach ($field_activity_field as $key => $value) { ?>
                                            <div class="profile-cat-listing clearfix">
                                                <div class="cat-icon"><img src="<?php print $path; ?>/images/pin-1.png" alt=""/></div>
                                                <div class="cat-text"><?php print $value['value']; ?></div>
                                                <?php
                                                if (check_review_exists($value['value'], $uid) != 0) {
                                                    $nid = check_review_exists($value['value'], $uid);
                                                    ?>
                                                    <?php if($user->uid == $curr_id){ ?>
													<div class="edit-cat"><a href="<?php print $base_url . "/node/" . $nid . "/edit" ?>" class="orange">Edit Review</a></div>
													<?php } ?>
                                                <?php } else { ?>
												<?php if($user->uid == $curr_id){ ?>
                                                    <div class="edit-cat"><a href="<?php print $base_url . "/node/add/review?est=" . $value['value'] ?>" class="orange">Write Review</a></div>
													<?php } ?>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div>
                                        <?php foreach ($field_sleep_field as $key => $value) { ?>
                                            <div class="profile-cat-listing clearfix">
                                                <div class="cat-icon"><img src="<?php print $path; ?>/images/sleepicon-1.png" alt=""/></div>
                                                <div class="cat-text"><?php print $value['value']; ?></div>
                                                <?php
                                                if (check_review_exists($value['value'], $uid) != 0) {
                                                    $nid = check_review_exists($value['value'], $uid);
                                                    ?>
													<?php if($user->uid == $curr_id){ ?> 
                                                    <div class="edit-cat"><a href="<?php print $base_url . "/node/" . $nid . "/edit" ?>" class="orange">Edit Review</a></div>
													<?php } ?>
                                                <?php } else { ?>
												<?php if($user->uid == $curr_id){ ?>
                                                    <div class="edit-cat"><a href="<?php print $base_url . "/node/add/review?est=" . $value['value'] ?>" class="orange">Write Review</a></div>
													<?php } ?>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-info-text">
                                <h2>About <?php print render($field_name_value); ?></h2>
                                <p><?php print render($field_bio_value); ?></p>
                            </div>
                            <div class="latest-profile-update">
                                <div class="profile-tab-heading clearfix">
                                    <h2><?php print render($field_name_value); ?> Update</h2>
                                   <?php if($user->uid == $curr_id){ ?> <a href="#">Post Status</a> <?php } ?>
                                </div>
                                <?php
                                if ($other_user_profile == 0) {
                                    module_load_include('inc', 'node', 'node.pages');

                                    $post_status_node_form = new stdClass;
                                    $post_status_node_form->uid = $user->uid;
                                    $post_status_node_form->name = (isset($user->name) ? $user->name : '');
                                    $post_status_node_form->type = 'status';
                                    $post_status_node_form->language = LANGUAGE_NONE;
                                    $post_status_form = drupal_get_form('status_node_form', $post_status_node_form); //$rtn .= drupal_render($form);
                                    //print drupal_render($post_status_form)
                                    ?>
                                    <form action="<?php print $post_status_form['#action']; ?>" method="<?php print $post_status_form['#method']; ?>" id="<?php print $post_status_form['#id']; ?>" accept-charset="UTF-8" enctype="multipart/form-data" class="node-form node-status-form">        
                                        <?php print drupal_render($post_status_form['field_post_status']); ?>
                    <?php print drupal_render($post_status_form['actions']['submit']); ?>
                                        <div style="display:none">
                                            <?php print drupal_render_children($post_status_form); ?>
                                        </div>

                                    </form>
                                    <?php
                                }
                                $block = module_invoke('views', 'block_view', 'post_status-block');
                                print render($block['content']);
                                ?>                
                            </div>
                        </div>
                    </div>
                </div>	
            </div>
        </div>
    </section>



    <!------------- FOOTER START --------------->
    <footer>
        <div class="newsletter-box">
            <div class="container">
                <div class="row clearfix">
                    <div class="col-sm-12 clearfix">
                        <?php if (!empty($page['newsletter_bar'])): ?>
                            <?php print render($page['newsletter_bar']); ?>
                        <?php endif; ?> 
                    </div>
                </div>
            </div>	
        </div>

        <div class="footer-menu">
            <div class="container">
                <div class="row clearfix">
                    <div class="col-sm-2">
                        <a href="#"><img src="<?php print $logo; ?>" class="img-responsive"></a>
                    </div>

                    <div class="col-sm-10">
                        <div class="footer-nav clearfix">
                            <?php print render($page['footer']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-copyrights">
            <div class="container">
                <div class="row clearfix">
                    <div class="col-sm-12">
                        <div class="text-center">
                            <div class="social-icon">
                                <?php print render($page['social_links']); ?>
                            </div>

                            <div class="copyright-text">
                                <?php print render($page['copyrights']); ?>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>



    <?php

    function check_review_exists($establishment = "", $uid) {
        global $user;
        $query = db_select('node', 'n');
        $query->join('field_data_field_review_name_of_est', 'est', 'n.nid = est.entity_id');
        $query->fields('n', array('nid'));
        $query->condition('n.uid', $uid, '=');
        $query->condition('est.bundle', 'review', '=');
        $query->condition('est.field_review_name_of_est_value', $establishment, '=');
        $query->orderBy('created', 'DESC'); //ORDER BY created
        $query->range(0, 1); //LIMIT to 2 re

        $result = $query->execute()->fetchAssoc();

        if (!empty($result)) {
            $nid = $result['nid'];
        } else {
            $nid = 0;
        }

        return $nid;
    }
    ?>