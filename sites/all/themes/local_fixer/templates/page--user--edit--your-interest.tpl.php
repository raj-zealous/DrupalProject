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
  <div class="content-wrapper step2">
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
            <h3>2.  YOUR interests</h3>

          </div>
          <div class="info-text">Share your interests so we can connect you with like-minded fixers!</div>
        </div>
      </div>
      <form action="<?php print $form['#action']; ?>" method="<?php print $form['#method']; ?>" id="<?php print $form['#id']; ?>" accept-charset="UTF-8" enctype="multipart/form-data" class="profile-form">
        <div class="row">
          <div class="col-sm-2">
            <div class="profile-details">
              <div class="profile-pic">
                <img src="<?php print $profileImage; ?>" width="100%" alt=""/>
              </div>
            </div>
          </div>
          <div class="col-sm-10">
            <div class="form-field-box">
              <?php print drupal_render($form['profile_your_interest']['field_interests']); ?>
            </div>
          </div>          
          <div class="col-sm-4">
            <div class="intrest-form" id="optionsForm">
              <?php
              $tree = taxonomy_get_nested_tree(2);
              $parent_count = 1;
              $return = '';
              foreach ($tree as $parent_term) {
                if (!(isset($parent_term->children))) {
                  $return .='<button data-target="" data-toggle="collapse" class="btn accordian-btn not-collapse" type="button">
  								<span class="button-icon"></span><span class="button-text">' . $parent_term->name . '</span>
						</button>';
                } else {
                  $return .= '<button type="button" class="btn accordian-btn collapsed" data-toggle="collapse" data-target="#demo' . $parent_count . '">
                  <span class="button-icon"></span><span class="button-text">' . $parent_term->name . '</span>
                </button>
									<div id="demo' . $parent_count . '" class="collapse">
                  <ul class="intrest-list">';
                  if (isset($parent_term->children)) {
                    foreach ($parent_term->children as $children) {
                      $sub_children_count = 1;
                      if (isset($children->children)) {
                        $return .= '<li>
                      <button type="button" class="btn accordian-btn collapsed" data-toggle="collapse" data-target="#subdemo' . $parent_count . '_' . $sub_children_count . '">
                        <span class="button-icon"></span><span class="button-text">Electronic music</span>
                      </button>
                      <div id="subdemo' . $parent_count . '_' . $sub_children_count . '" class="collapse">
                        <ul class="intrest-list">';
                        foreach ($children->children as $sub_children) {
                          $return .='<li><a href="#">' . $sub_children->name . '</a></li>';
                        }
                        $return .='</ul></div></li>';
                      } else {
                        $return .='<li><a href="#">' . $children->name . '</a></li>';
                      }
                    }
                  }
                  $return .='</ul>
									</div>
					';
                  $parent_count++;
                }
              }

              print $return;
              ?>

            </div>
          </div>

        </div>

        <div class="row">
          <div class="col-sm-2 hidden-xs"></div>
          <div class="col-sm-5">
            <div class="navbar-text">
              <ul id="interest_user">
                <?php
                $output = '';
                foreach ($form['profile_your_interest']['field_interests']['und']['#default_value'] as $key => $value) {
                  $output .='<li><a><img src="/sites/all/themes/local_fixer/images/in-cross.png"></a>' . $form['profile_your_interest']['field_interests']['und']['#options'][$value] . '</li>';
                }
                print $output;
                ?>              
              </ul>
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