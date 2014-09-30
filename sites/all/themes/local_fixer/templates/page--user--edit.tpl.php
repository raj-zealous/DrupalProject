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
 */
global $base_url;
global $user;
$path = $base_url . '/' . path_to_theme();
if (!($user->uid)) {
  drupal_set_message("Login required.", $type="error");
  header('Location: ' . $base_url);
}

$form = $page['content']['system_main'];


/* code to get default image of User */
$default_pic = variable_get('user_picture_default', $path . '/images/pic.png');
$image_uri = '';
if (!empty($form['#user']->picture->uri)) {
  $image_uri = $form['#user']->picture->uri;
}

if (($image_uri == "") || ($image_uri == NULL)) {
  $profileImage = $base_url . $default_pic;
} else {
  $profileImage = file_create_url($image_uri);
}

//$form['account']['pass']['#attached'] = array();
//$form['account']['pass']['pass1']['#prefix'] = '';
//$form['account']['pass']['pass1']['#title'] = '';
//$form['account']['pass']['pass1']['#theme_wrappers'] = array(); // remove the wrapper
//$form['account']['pass']['pass1']['#suffix'] = '';
//$form['account']['pass']['pass1']['#title_display'] = 'none';
//$form['account']['pass']['pass1']['#attributes']['placeholder'] = t('Password*');
//$form['account']['pass']['pass1']['#description'] = '';
//
//$form['account']['pass']['pass2']['#prefix'] = '';
//$form['account']['pass']['pass2']['#title'] = '';
//$form['account']['pass']['pass2']['#theme_wrappers'] = array(); // remove the wrapper
//$form['account']['pass']['pass2']['#suffix'] = '';
//$form['account']['pass']['pass2']['#title_display'] = 'none';
//$form['account']['pass']['pass2']['#attributes']['placeholder'] = t('Confirm Password*');
//$form['account']['pass']['pass2']['#description'] = '';
?>

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
  <!------------- CONTENT START --------------->
  <div class="content-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <?php if ($messages): ?>
            <div id="messages_reg"><div class="section clearfix">
                <?php print_r($messages); ?>
              </div>
            </div>
          <?php endif; ?>

          <a id="main-content"></a> 

          <?php if (!empty($page['help'])): ?>
            <?php print render($page['help']); ?>
          <?php endif; ?>
          <?php if (!empty($action_links)): ?>
            <ul class="action-links">
              <?php print render($action_links); ?>
            </ul>
          <?php endif; ?>


          <div class="profile-info-box clearfix">
            <h3>1.  <?php print "My Profile"; ?></h3>
            <span>Joined on <?php echo date('M d,Y', $form['#user']->created); ?></span>
          </div>
          <div class="info-text">Complete your fixer profile to get started.<span> (* required field)</span></div>
        </div>
      </div>
      <form action="<?php print $form['#action']; ?>" method="<?php print $form['#method']; ?>" id="<?php print $form['#id']; ?>" accept-charset="UTF-8" enctype="multipart/form-data" class="profile-form">
        <div class="row">
          <div class="col-sm-2">
            <?php 
			
			print drupal_render($form['picture']); ?>
          </div>
          <div class="col-sm-4">
            <div class="signup-form" id="optionsForm">
              <div class="form-field-box">
                <?php print drupal_render($form['profile_main']['field_name']); ?>
              </div>
              <div class="form-field-box">
                <?php print drupal_render($form['account']['mail']); ?>
              </div>
              <!--              <div class="form-field-box pw-box clearfix">
              <?php print drupal_render($form['account']['pass']['pass1']); ?>
              <?php print drupal_render($form['account']['pass']['pass2']); ?>
                            </div>-->
              <div class="form-field-box">
                <?php print drupal_render($form['profile_main']['field_country']); ?>
              </div>
              <div class="form-field-box city-box clearfix">
                <?php print drupal_render($form['profile_main']['field_city']); ?>
                <?php print drupal_render($form['profile_main']['field_postcode']); ?>
              </div>
              <div class="form-field-box">
                <div class="location-box clearfix">
                  <?php print drupal_render($form['profile_main']['field_current_location']); ?>
                </div>
              </div>
              <div class="form-field-box">
                <div class="clearfix">
                  <div class="">
                    <?php print drupal_render($form['profile_main']['field_gender']); ?>
                    <?php print drupal_render($form['profile_main']['field_hide_gender']); ?>
                  </div>
                </div>
              </div>
              <div class="form-field-box">
                <div class="clearfix">
                  <label>Date of birth *</label>
                  <?php print drupal_render($form['profile_main']['field_birth_date']); ?>
                </div>
              </div>
              <div class="form-field-box">
                <div class="location-box clearfix">                  
                  <?php print drupal_render($form['profile_main']['field_hide_birth_date']); ?>
                </div>
              </div>
              <div class="form-field-box">
                <?php print drupal_render($form['profile_main']['field_bio']); ?>
              </div>
            </div>
          </div>

          <div class="col-sm-4">
            <div class="recom-data">
              <div class="recommendation">
                <p>Share your recommendations</p> 
                (minimum of 1 recommendation for each is required)
              </div>
              <div class="recom-box">
                <?php
                $foodCounter = 0;
                if (!empty($form['profile_main']['field_food']['und'][0]['value']['#default_value'])) {
                  $food_default_value_0 = $form['profile_main']['field_food']['und'][0]['value']['#default_value'];
                  $foodCounter++;
                } else {
                  $foodCounter++;
                }
                if (!empty($form['profile_main']['field_food']['und'][1]['value']['#default_value'])) {
                  $food_default_value_1 = $form['profile_main']['field_food']['und'][1]['value']['#default_value'];
                  $foodCounter++;
                }
                if (!empty($form['profile_main']['field_food']['und'][2]['value']['#default_value'])) {
                  $food_default_value_2 = $form['profile_main']['field_food']['und'][2]['value']['#default_value'];
                  $foodCounter++;
                }
                //echo $foodCounter;die;
                ?>
                <div class="recom-heading clearfix">
                  <img src="<?php print $path; ?>/images/foodicon.png" alt="Food"/>
                  <h3>Food (places to eat) *</h3>
                  <a href="javascript:void(0)" onClick="addInput('food', 'food_rec', 'foodCnt')">+ Add</a>
                  <input type="hidden" id="foodCnt" value="<?php print $foodCounter; ?>"/>
                </div>
                <div id="food">
                  <?php if (!empty($food_default_value_0)) { ?>
                    <div class="recom-field-box">
                      <input type="text" placeholder='' value="<?php print $food_default_value_0; ?>" name='food_rec[]'>
                      <span><img src="<?php print $path; ?>/images/righticon.png" alt=""/></span>
                    </div>
                  <?php } else { ?>
                    <div class="recom-field-box">
                      <input type="text" placeholder='Dead Man Espresso' name='food_rec[]' onblur='javascript:addTick(this)'>
                    </div>
                  <?php } ?>
                  <?php if (!empty($food_default_value_1)) { ?>
                    <div class="recom-field-box">
                      <input type="text" placeholder='' value="<?php print $food_default_value_1; ?>" name='food_rec[]'>
                      <span><img src="<?php print $path; ?>/images/righticon.png" alt=""/></span>
                    </div>
                  <?php } ?>
                  <?php if (!empty($food_default_value_2)) { ?>
                    <div class="recom-field-box">
                      <input type="text" placeholder='' value="<?php print $food_default_value_2; ?>" name='food_rec[]'>
                      <span><img src="<?php print $path; ?>/images/righticon.png" alt=""/></span>
                    </div>
                  <?php } ?>
                </div>
              </div>
              <div class="recom-box">
                <?php
                $drinkCounter = 0;
                if (!empty($form['profile_main']['field_drink']['und'][0]['value']['#default_value'])) {
                  $drink_default_value_0 = $form['profile_main']['field_drink']['und'][0]['value']['#default_value'];
                  $drinkCounter++;
                } else {
                  $drinkCounter++;
                }
                if (!empty($form['profile_main']['field_drink']['und'][1]['value']['#default_value'])) {
                  $drink_default_value_1 = $form['profile_main']['field_drink']['und'][1]['value']['#default_value'];
                  $drinkCounter++;
                }
                if (!empty($form['profile_main']['field_drink']['und'][2]['value']['#default_value'])) {
                  $drink_default_value_2 = $form['profile_main']['field_drink']['und'][2]['value']['#default_value'];
                  $drinkCounter++;
                }
                //echo $drinkCounter;die;
                ?>

                <div class="recom-heading clearfix">
                  <img src="<?php print $path; ?>/images/drinkicon.png" alt="Drink"/>
                  <h3>Drink (places to drink) *</h3>
                  <a href="javascript:void(0)" onClick="addInput('drink', 'drink_rec', 'drinkCnt')">+ Add</a>
                  <input type="hidden" id="drinkCnt" value="<?php print $drinkCounter; ?>"/>
                </div>
                <div id="drink">
                  <?php if (!empty($form['profile_main']['field_drink']['und'][0]['value']['#default_value'])) { ?>
                    <div class="recom-field-box">
                      <input type="text" placeholder='' value="<?php print $form['profile_main']['field_drink']['und'][0]['value']['#default_value'] ?>" name='drink_rec[]'>
                      <span><img src="<?php print $path; ?>/images/righticon.png" alt=""/></span>
                    </div>
                  <?php } else { ?>
                    <div class="recom-field-box">
                      <input type="text" placeholder='' name='drink_rec[]' onblur='javascript:addTick(this)'>                     
                    </div>
                  <?php } ?>
                  <?php if (!empty($form['profile_main']['field_drink']['und'][1]['value']['#default_value'])) { ?>
                    <div class="recom-field-box">
                      <input type="text" placeholder='' value="<?php print $form['profile_main']['field_drink']['und'][1]['value']['#default_value'] ?>" name='drink_rec[]'>
                      <span><img src="<?php print $path; ?>/images/righticon.png" alt=""/></span>
                    </div>
                  <?php } ?>
                  <?php if (!empty($form['profile_main']['field_drink']['und'][2]['value']['#default_value'])) { ?>
                    <div class="recom-field-box">
                      <input type="text" placeholder='' value="<?php print $form['profile_main']['field_drink']['und'][2]['value']['#default_value'] ?>" name='drink_rec[]'>
                      <span><img src="<?php print $path; ?>/images/righticon.png" alt=""/></span>
                    </div>
                  <?php } ?>
                </div>
              </div>
              <div class="recom-box">
                <?php
                $activityCounter = 0;
                if (!empty($form['profile_main']['field_activity']['und'][0]['value']['#default_value'])) {
                  $activity_default_value_0 = $form['profile_main']['field_activity']['und'][0]['value']['#default_value'];
                  $activityCounter++;
                } else {
                  $activityCounter++;
                }
                if (!empty($form['profile_main']['field_activity']['und'][1]['value']['#default_value'])) {
                  $activity_default_value_1 = $form['profile_main']['field_activity']['und'][1]['value']['#default_value'];
                  $activityCounter++;
                }
                if (!empty($form['profile_main']['field_activity']['und'][2]['value']['#default_value'])) {
                  $activity_default_value_2 = $form['profile_main']['field_activity']['und'][2]['value']['#default_value'];
                  $activityCounter++;
                }
                //echo $activityCounter;die;
                ?>
                <div class="recom-heading clearfix">
                  <img src="<?php print $path; ?>/images/acticon.png" alt="Activity"/>
                  <h3>Activity (where do the locals hangout?) *</h3>
                  <a href="javascript:void(0)" onClick="addInput('activity', 'activity_rec', 'activityCnt')">+ Add</a>
                  <input type="hidden" id="activityCnt" value="<?php print $activityCounter; ?>"/>
                </div>
                <div id="activity">
                  <?php if (!empty($form['profile_main']['field_activity']['und'][0]['value']['#default_value'])) { ?>
                    <div class="recom-field-box">
                      <input type="text" placeholder='' value="<?php print $form['profile_main']['field_activity']['und'][0]['value']['#default_value'] ?>" name='activity_rec[]'>
                      <span><img src="<?php print $path; ?>/images/righticon.png" alt=""/></span>
                    </div>
                  <?php } else { ?>
                    <div class="recom-field-box">
                      <input type="text" placeholder='' name='activity_rec[]' onblur='javascript:addTick(this)'>
                    </div>
                  <?php } ?>
                  <?php if (!empty($form['profile_main']['field_activity']['und'][1]['value']['#default_value'])) { ?>
                    <div class="recom-field-box">
                      <input type="text" placeholder='' value="<?php print $form['profile_main']['field_activity']['und'][1]['value']['#default_value'] ?>" name='activity_rec[]'>
                      <span><img src="<?php print $path; ?>/images/righticon.png" alt=""/></span>
                    </div>
                  <?php } ?>
                  <?php if (!empty($form['profile_main']['field_activity']['und'][2]['value']['#default_value'])) { ?>
                    <div class="recom-field-box">
                      <input type="text" placeholder='' value="<?php print $form['profile_main']['field_activity']['und'][2]['value']['#default_value'] ?>" name='activity_rec[]'>
                      <span><img src="<?php print $path; ?>/images/righticon.png" alt=""/></span>
                    </div>
                  <?php } ?>
                </div>
              </div>
              <div class="recom-box">
                <?php
                $sleepCounter = 0;
                if (!empty($form['profile_main']['field_sleep']['und'][0]['value']['#default_value'])) {
                  $sleep_default_value_0 = $form['profile_main']['field_sleep']['und'][0]['value']['#default_value'];
                  $sleepCounter++;
                } else {
                  $sleepCounter++;
                }
                if (!empty($form['profile_main']['field_sleep']['und'][1]['value']['#default_value'])) {
                  $sleep_default_value_1 = $form['profile_main']['field_sleep']['und'][1]['value']['#default_value'];
                  $sleepCounter++;
                }
                if (!empty($form['profile_main']['field_sleep']['und'][2]['value']['#default_value'])) {
                  $sleep_default_value_2 = $form['profile_main']['field_sleep']['und'][2]['value']['#default_value'];
                  $sleepCounter++;
                }
                //echo $sleepCounter;die;
                ?>

                <div class="recom-heading clearfix">
                  <img src="<?php print $path; ?>/images/sleepicon.png" alt="Sleep"/>
                  <h3>Sleep (places to stay) *</h3>
                  <a href="javascript:void(0)" onClick="addInput('sleep', 'sleep_rec', 'sleepCnt')">+ Add</a>
                  <input type="hidden" id="sleepCnt" value="<?php print $sleepCounter; ?>"/>
                </div>
                <div id="sleep">
                  <?php if (!empty($form['profile_main']['field_sleep']['und'][0]['value']['#default_value'])) { ?>
                    <div class="recom-field-box">
                      <input type="text" placeholder='' value="<?php print $form['profile_main']['field_sleep']['und'][0]['value']['#default_value'] ?>" name='sleep_rec[]'>
                      <span><img src="<?php print $path; ?>/images/righticon.png" alt=""/></span>
                    </div>
                  <?php } else { ?>
                    <div class="recom-field-box">
                      <input type="text" placeholder='' name='sleep_rec[]' onblur='javascript:addTick(this)'>
                    </div>
                  <?php } ?>
                  <?php if (!empty($form['profile_main']['field_sleep']['und'][1]['value']['#default_value'])) { ?>
                    <div class="recom-field-box">
                      <input type="text" placeholder='' value="<?php print $form['profile_main']['field_sleep']['und'][1]['value']['#default_value'] ?>" name='sleep_rec[]'>
                      <span><img src="<?php print $path; ?>/images/righticon.png" alt=""/></span>
                    </div>
                  <?php } ?>
                  <?php if (!empty($form['profile_main']['field_sleep']['und'][2]['value']['#default_value'])) { ?>
                    <div class="recom-field-box">
                      <input type="text" placeholder='' value="<?php print $form['profile_main']['field_sleep']['und'][2]['value']['#default_value'] ?>" name='sleep_rec[]'>
                      <span><img src="<?php print $path; ?>/images/righticon.png" alt=""/></span>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2 hidden-xs"></div>
          <div class="col-sm-5">
            <div class="continue">
              <?php print drupal_render($form['actions']['submit']); ?>
            </div>
          </div>
        </div>
        <div style="display:none">
          <?php print drupal_render_children($form); ?>
        </div>

      </form>
    </div>
  </div>
</div>



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
<script type="text/javascript">
            jQuery(document).ready(function() {
            	jQuery(".user-picture img").removeAttr('alt');    
            });  
				    function performClick(node) {
                      var evt = document.createEvent("MouseEvents");
                      evt.initEvent("click", true, false);
                      node.dispatchEvent(evt);
                    }
</script>