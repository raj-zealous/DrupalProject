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
$theme_path = $base_url . '/' . path_to_theme();

if(isset($_POST['reg_code']) && $_POST['reg_code'] != ''){
	$checkCode = db_query("select code from {tbl_assigned_code} where code ='".$_REQUEST['reg_code']."'");
	$cntCode =  $checkCode->rowCount();
	if($cntCode > 0){
		foreach($checkCode as $cd){
		}
		$_SESSION['reg_code'] = $cd->code;
	}else{
		$_REQUEST['msg'] = 'notValid';
	}
	
}

?>
<?php if (!empty($page['feedback_form'])): ?>
  <?php print render($page['feedback_form']); ?>
<?php endif; ?>
<div class="wrapper">
<?php if($user->uid != '' || (isset($_SESSION['reg_code']) && $_SESSION['reg_code'] != '')) { 
?>
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
          <a class="navbar-brand" href="<?php echo $base_url ?>"><img src="<?php print $logo; ?>" class="title"></a>
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

  <?php if (!empty($page['highlighted'])): ?>
    <div class="highlighted jumbotron"><?php print render($page['highlighted']); ?></div>
  <?php endif; ?>
  <?php
  if (!empty($breadcrumb)): print $breadcrumb;
  endif;
  ?>
  <a id="main-content"></a> <?php print render($title_prefix); ?>
  <?php if (!empty($title)): ?>
    <h1 class="page-header"><?php print $title; ?></h1>
  <?php endif; ?>
  <?php print render($title_suffix); ?> <?php print $messages; ?>
  <?php if (!empty($tabs)): ?>
    <?php print render($tabs); ?>
  <?php endif; ?>
  <?php if (!empty($page['help'])): ?>
    <?php print render($page['help']); ?>
  <?php endif; ?>
  <?php if (!empty($action_links)): ?>
    <ul class="action-links">
      <?php print render($action_links); ?>
    </ul>
  <?php endif; ?>
  

  <section id="container-top-bar" class="content-top-bar fullheight">
    <div class="container">
      <div class="row clearfix">
        <div class="col-sm-12">
          <?php if (!empty($page['content_top_bar'])): ?>
            <?php print render($page['content_top_bar']); ?>
<?php endif; ?> 
          <div class="page-scroll text-center">
            <a href="#container-bottom-bar" class="down-arrow"></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section<?php print $content_column_class; ?>>
<?php //print render($page['content']);    ?> 
  </section>

  <section id="container-bottom-bar" class="content-top-bar fullheight">
    <div class="container">
      <div class="row clearfix">
        <div class="col-sm-12">
          <div class="page-scroll text-center">
            <a href="#container-top-bar" class="top-arrow"></a>
          </div>

          <?php if (!empty($page['content_bottom_bar'])): ?>
            <?php print render($page['content_bottom_bar']); ?>
<?php endif; ?> 
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
  <?php }
  else{ 
  
  ?>
<style type="text/css">
body{padding-top:0px !important}
</style>
	<?php
global $base_url, $user;

$path = $base_url . '/' . path_to_theme(); 
?>
<?php if (!empty($_SESSION['logout_message'])) { ?>
    <section id="container" class="logout-message">
      <div class="container">
        <div class="row clearfix">
          <div class="col-sm-12">
            <h2>
              <?php
              print $_SESSION['logout_message'];
              $_SESSION['logout_message'] = '';
			  unset($_SESSION['logout_message']);
              ?>
            </h2>
          </div>
        </div>
      </div>
    </section>
    <?php
  }
  ?>
<section id="about-page-content" class="">
<nav id="primary">
				<ul class="HashLi">
					<li>
						<a class="home1" href="#home1">View</a>
					</li>
					<li>
						<a class="about1" href="#about1">View</a>
					</li>
					<li>
						<a class="about2" href="#about2">View</a>
					</li>
					<li>
						<a class="about3" href="#about3">View</a>
					</li>
                    <li>
						<a class="about4" href="#about4">View</a>
					</li>
				</ul>
			</nav>
<div class="home-box1 home-box1-new text-center" id="home1">
<div class="container">
	<div class="row clearfix">
		<div class="co1-sm-12 text-center">
        
		<?php if(isset($_REQUEST['msg']) && $_REQUEST['msg'] != ''){ ?>	 
        <div class="alert alert-block alert-danger">
  			<a href="#" data-dismiss="alert" class="close">×</a>
		<span><?php 
		if($_REQUEST['msg'] == 'notValid'){
			echo 'Please Enter Valid Code';
		} ?></span>
        </div>
        <?php } ?>
        
            
			<div class="about-icon-top  logo-mar">
            <img src="<?php print $path?>/images/local_fixer_logo.png" class="img-responsive">
            
            </div>
            <h2>Are You Ready to Change</h2>
            <h1>The Way You Travel?</h1>
            <form name="reg_codeform" action="" method="post" id="reg_codeform" >
            <div class="popup-form-field popup-form-field-new">
                <div class="form-type-textfield form-item-name form-item">
                  <input type="password" maxlength="60" size="25" value="" name="reg_code" id="reg_code" class="form-control-ing text-center col-sm-4 form-text required" placeholder="Enter Password" autofocus="autofocus" style="float:none;">
                  
                </div>
            </div>
            
            <!--div class="about-text clearfix">Local Fixer is an <span>innovative new way</span> to travel. </div-->
            <div class="about-para about-para-new clearfix">We aren't ready for everyone join yet (you currently need a password invitation code). We want to finding fixers to play an active role in helping us grow and develop the ultimate travel community!</div>
            <div class="about-para about-para-new clearfix">What are you waiting for? Sign up, take off, travel local...</div>
            <div class="text-center a-tag"><a href="#about4">Click here to Invited.</a></div>
            </form>
        </div>
	</div>
</div>


</div>

<?php /*
// my Custom block to display content
 ?>
<div class="about-box1 about-box1-new text-center" id="about1">
<a href="#home1" class="arrow-up home1"></a>
<a href="#about2" class="arrow-down about2" ></a>
 <?php if (!empty($page['about_box1'])): ?>
            <?php print render($page['about_box1']); ?>
          <?php endif; ?> 


</div>
<?php */ ?>

<div class="about-box1 about-box1-new text-center" id="about1">
<a href="#home1" class="arrow-up home1"></a>
<a href="#about2" class="arrow-down about2" ></a>
<div class="container">
	<div class="row clearfix">
		<div class="co1-sm-12 text-center">
        	<h1>What is Local Fixer?</h1>
			<div class="about-icon-top"><a href="#"> <img src="<?php print $path?>/images/play-icon.png" class="img-responsive"></a></div>
            <h2>A different way to travel</h2>
            <div class="about-para clearfix">Local Fixer is proud to be involved with Collaborative Consumption. This rapidly growing global movement is about challenging the way we think about consumption and promotes sharing, swapping, trading and renting products and services in a way that improves accessibility.</div>    
        </div>
	</div>
</div>


</div>

<div class="about-box2 about-box2-new text-center" id="about2">
<a href="#about1" class="arrow-up about1"></a>
<a href="#about3" class="arrow-down about3"></a>
<div class="container">
	<div class="row clearfix">
		<div class="co1-sm-12 text-center">
        	<h1>How does it work?</h1>
            <h2>Connect with locals and share hidden secrets in your city</h2>
            <div class="about-para clearfix">Local Fixer gets you the best information to enjoy genuine travel experiences. It matches you to locals around the world and lets you know what they love about their city. Here’s how:</div>
            
            <div class="howit-work-data">
            	<div class="row clearfix">
                	<div class="col-sm-4">
                    	<div class="work-databox text-center">
                        		<div class="work-icon"><img src="<?php print $path?>/images/about-search-icon-new.png" class="img-responsive"></div>
                                <div class="work-text">Search for likeminded fixers based on location, interests, demographic and reviews, and get real local knowledge about your next travel destination.</div>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                    	<div class="work-databox text-center">
                        		<div class="work-icon"><img src="<?php print $path?>/images/about-intract-icon-new.png" class="img-responsive"></div>
                                <!-- <div class="work-title">Interact</div> -->
                                <div class="work-text">As well as reading fixers’ reviews, you can message them to find out their city’s hidden secrets. You might arrange to meet up or borrow their stuff.</div>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                    	<div class="work-databox text-center">
                        		<div class="work-icon"><img src="<?php print $path?>/images/about-save-icon-new.png" class="img-responsive"></div>
                                <!-- <div class="work-title">Share</div> -->
                                <div class="work-text">Use Local Fixer to share all your travel experiences, stories, photos and more. The more you share, the better everyone’s travels will be.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>


</div>
<div class="about-box3 about-box3-new text-center" id="about3">
<a href="#about2" class="arrow-up about2"></a>
<a href="#about4" class="arrow-down about4"></a>
<div class="container">
	<div class="row clearfix">
		<div class="co1-sm-12 text-center">
        	<h1>Consume Collaboratively</h1>
			<div class="about-icon-top"><img src="<?php print $path?>/images/about-collabrate-icon-new.png" class="img-responsive"></div>
            <h2>Think differently about what you need when you travel</h2>
            <div class="about-para clearfix">Local Fixer is proud to be involved with Collaborative Consumption. This rapidly growing global movement is about challenging the way we think about consumption and promotes sharing, swapping, trading and renting products and services in a way that improves accessibility.</div>
            
            <div class="about-para clearfix">Local Fixer embraces this movement by allowing fixers to share their things when out on the road, and by providing accommodation options through multiple sites.</div>
        </div>
	</div>
</div>


</div>
<div class="about-box4 about-box4-new text-center" id="about4">
<a class="arrow-up about3" href="#about3" ></a>
<div class="container">
	<div class="row clearfix">
		<div class="co1-sm-12 text-center" id="invite_box">
        	<!--<h1>Our Story</h1>
			<div class="about-icon-top"><img src="<?php print $path?>/images/about-story-icon.png" class="img-responsive"></div>
            <div class="about-para clearfix">Local Fixer started as a project between four founding fixers from Australia: Andrew, Sean, Elliot and Josh. All four travel tragics agreed that their favourite part of globetrotting was the genuine local experiences they enjoyed when interacting with locals around the world.</div>
            <div class="about-para clearfix">As they repeatedly introduced each other to local contacts around the globe, they realised that many people shared a passion for experiencing travel with new local friends.</div>
-->        <h2>Stay tuned, we are launching very soon...</h2>
			<div class="popup-form-field ">
                <div class="form-type-textfield form-item-name form-item">
                  <input type="text" maxlength="60" size="25" value="" name="invite_email" id="invite_email" class="form-control-ing text-center col-sm-4 form-text required" placeholder="email.address@website.com"  style="float:none;width:30% ">
                  <button type="button" value="GET INVITED!" name="invite" id="invite_btn" class="btn-orange btn btn-primary form-submit" >GET INVITED!</button>
                </div>
                <div id="msg_div"></div>
            </div>
            
            <!--div class="about-text clearfix">Local Fixer is an <span>innovative new way</span> to travel. </div-->
            <ul>
            	<li><a href="https://www.facebook.com/localfixertravel" target="_blank"><img src="<?php print $path?>/images/fb-icon.png" ></a></li>
                <li><a href="https://twitter.com/Local_Fixer" target="_blank"><img src="<?php print $path?>/images/tw-icon.png"></a></li>
                <li><a href="http://instagram.com/localfixer" target="_blank"><img src="<?php print $path?>/images/ph-icon.png"></a></li>
                <li><a href="#"><img src="<?php print $path?>/images/mail-icon.png"></a></li>
            </ul>
            <div class="about-para clearfix">© Copyright 2014 Local fixer. Website by Jumbla</div>
</div>
	</div>
</div>
</div>
</section>
<script type="text/javascript">
 var $ = jQuery.noConflict();
 jQuery(document).ready(function() {
	 
	 
	jQuery("#about-page-content div a").click(function(){
		var id = jQuery(this).attr('href');
		window.location.href="<?php echo $base_url; ?>/"+id;
	});
	 
	 
    jQuery("#invite_btn").click(function(){
		var invite_email = jQuery("#invite_email").val();
		var r = new RegExp("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?");
    
	if(invite_email.match(r) != null){
			jQuery.ajax({
				type:'post',
				url:'<?php echo path_to_theme(); ?>/templates/invite_email.php',
				data:{invite_email:invite_email},
				/*beforeSend: function() {

					$("#loadingDiv1").show();

				},*/
				success: function( response ) {
					jQuery("#msg_div").html(response);
				 }	
				});
	}else{
		jQuery("#invite_email").val('');
		jQuery("#invite_email").focus();
		jQuery("#msg_div").html('Please Enter Valid Email Address');
		return false;
	}
	
	//return (v.match(r) == null) ? false : true;
	
		
	});
	
	jQuery('a[href*=#]:not([href=#])').click(function() {
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			var chkVal = $(this).attr('href');
	     	var fnchkVal = chkVal.replace("#", "");
			$("#primary>ul>li>a.active").removeClass("active");
			$('.'+fnchkVal).addClass("active");
			
		  var target = $(this.hash);
	      target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
	      
		  if (target.length) {
	      	jQuery('html,body').animate({
	          scrollTop: target.offset().top
	        }, 1000);
	        return false;
	      }
	    }
	  });
});




 </script> 
 
<?php } ?>
</div>