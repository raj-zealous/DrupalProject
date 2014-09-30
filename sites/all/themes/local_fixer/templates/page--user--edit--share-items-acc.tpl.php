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
  drupal_set_message("Login required.", $type = "error");
  header('Location: ' . $base_url);
}


module_load_include('inc', 'node', 'node.pages');
$staff_node_form = new stdClass;
$staff_node_form->uid = $user->uid;
$staff_node_form->name = (isset($user->name) ? $user->name : '');
$staff_node_form->type = 'stuff';
$staff_node_form->language = LANGUAGE_NONE;
$staff_form = drupal_get_form('stuff_node_form', $staff_node_form); //$rtn .= drupal_render($form);

$accomodation_node_form = new stdClass;
$accomodation_node_form->uid = $user->uid;
$accomodation_node_form->name = (isset($user->name) ? $user->name : '');
$accomodation_node_form->type = 'accomodation';
$accomodation_node_form->language = LANGUAGE_NONE;
$accomodation_form = drupal_get_form('accomodation_node_form', $accomodation_node_form); //$rtn .= drupal_render($form);

/* code to include user.inc file to required to get user data */
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
?>


<?php if (!empty($page['feedback_form'])): ?>
  <?php print render($page['feedback_form']); ?>
<?php endif; ?>

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

          <div class="profile-info-box clearfix">
            <h3>3.  Share Your items & accommodation &nbsp;<span>(optional)</span></h3>
          </div>
          <div class="info-text">Share a place to stay and items that will help fixers on their travels.</span></div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-2">
          <div class="profile-details">
            <div class="profile-pic">
              <img src="<?php print $profileImage; ?>" width="100%" alt=""/>
            </div>
          </div>
        </div>
        <div class="col-sm-5">

          <?php //print drupal_render($staff_form); ?>
          <div class="share-form" id="optionsForm">
            <form action="<?php print $staff_form['#action']; ?>" method="<?php print $staff_form['#method']; ?>" id="<?php print $staff_form['#id']; ?>" accept-charset="UTF-8" enctype="multipart/form-data" class="node-form node-stuff-form">        

              <h2 class="share-title"><span>Share Stuff</span></h2>
              <div class="share-form-box">
                <?php print drupal_render($staff_form['title']); ?>
              </div>
              <div class="share-form-box clearfix">
                <div class="file-upload">
                  <?php print drupal_render($staff_form['field_stuff_image']); ?>
                </div>
                <div class="nights-no">                
                  <?php print drupal_render($staff_form['field_no_nights']); ?>
                </div>
              </div>
              <div class="share-form-box">
                <div class="clearfix">
                  <div class="">
                    <?php print drupal_render($staff_form['field_stuff_date']); ?>

                  </div>
                </div>
                <div class="share-form-box">                  
                  <?php print drupal_render($staff_form['field_stuff_price']); ?>
                </div>

                <div class="share-form-box">
                  <?php print drupal_render($staff_form['field_stuff_description']); ?>
                </div>
                <div class="share-form-box">
                  <?php print drupal_render($staff_form['actions']['submit']); ?>
                </div>
              </div>
              <div style="display:none">
                <?php print drupal_render_children($staff_form); ?>
              </div>

            </form>
          </div>

        </div>

        <div class="col-sm-5">
          <div class="share-form" id="optionsForm"><form action="<?php print $accomodation_form['#action']; ?>" method="<?php print $accomodation_form['#method']; ?>" id="<?php print $accomodation_form['#id']; ?>" accept-charset="UTF-8" enctype="multipart/form-data" class="node-form node-accomodation-form">        

              <h2 class="accommodation-title"><span>Accommodation</span></h2>
              <div class="share-form-box">
                <?php print drupal_render($accomodation_form['title']); ?>
              </div>
              <div class="share-form-box clearfix">
                <div class="file-upload">
                  <?php print drupal_render($accomodation_form['field_accomodation_image']); ?>
                </div>
                <div class="nights-no">                
                  <?php print drupal_render($accomodation_form['field_no_of_nights']); ?>
                </div>
              </div>
              <div class="share-form-box">
                <div class="clearfix">
                  <div class="">
                    <?php print drupal_render($accomodation_form['field_accomodation_date']); ?>

                  </div>
                </div>
                <div class="share-form-box">                  
                  <?php print drupal_render($accomodation_form['field_accomodation_price_per_nig']); ?>
                </div>

                <div class="share-form-box">
                  <?php print drupal_render($accomodation_form['field_accomodation_description']); ?>
                </div>
                <div class="share-form-box">
                  <?php print drupal_render($accomodation_form['actions']['submit']); ?>
                </div>
              </div>
              <div style="display:none">
                <?php print drupal_render_children($accomodation_form); ?>
              </div>

            </form>




          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-2 hidden-xs"></div>
        <div class="col-sm-5">
          <div class="continue">
            <button type="submit" value="CONTINUE" onclick="window.location = '<?php print $base_url; ?>'" id="edit-submit" class="btn-orange btn  form-submit">CONTINUE</button>
            <button class="gray-btn" type="button" onclick="window.location = '<?php print $base_url; ?>'">Skip</button>
          </div>
        </div>
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
              function performClick(node) {
                var evt = document.createEvent("MouseEvents");
                evt.initEvent("click", true, false);
                node.dispatchEvent(evt);
              }
  </script>