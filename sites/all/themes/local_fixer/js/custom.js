var allowHash = 1;

jQuery(document).ready(function() {
  // Dharmesh Patel changes start
  jQuery('#block-menu-menu-social-links-menu ul li a').html('');
  jQuery('.newsletter-form #edit-newsletter-submit').attr('class', 'black-btn');
  jQuery('#newsletter-manage-subscriptions-form #edit-submit').attr('class', 'default-button btn-orange');
  jQuery('#webform-ajax-wrapper-10 .grippie').attr('class', '');
  jQuery('.send-btn .btn').attr('class', 'btn-orange');
  jQuery('.grippie').attr('class', '');
  jQuery('.feedback-textbox label').remove();
  jQuery('#block-newsletter-newsletter-subscribe .block-title').remove();
  jQuery('#block-mailchimp-lists-newsletter .block-title').remove();
  // jQuery('#edit-preview').html('');
  jQuery('.form-item-comment-body-und-0-value label').remove();

  jQuery('.help-block').remove();
  jQuery('.form-item-field-msg-attache-und-0 label').remove();
  jQuery('.form-item-field-msg-attache-und-0 .input-group-btn').remove();
  jQuery('#emoticons').hide();

  jQuery('.form-item-field-msg-attache-und-0 .form-managed-file').append('<a class="msg-camera" href="javascript:void(0)"/>');
  jQuery('.form-item-field-msg-attache-und-0 .form-managed-file').append('<a class="msg-smiley" href="javascript:void(0)"/>');


  jQuery("#edit-submitted-which-field-best-describes-your-problem > option:first").html('Please choose one');
  var html_msg = jQuery(".unread_msg_cont a").html();
  //var cnt = html_msg.replace("My messages", "");
  var cnt = '';
  var html_content_append = jQuery(".unread_msg_cont a").html("<span class = 'unread_msg_cnt'> " + cnt + " </span>" + "My messages");

  setformfieldsize(jQuery('#edit-submitted-describe-your-problem-here'), 500, 'charsremain');
  jQuery('#edit-submitted-describe-your-problem-here').keyup(function() {
    var left = 500 - jQuery(this).val().length;
    if (left < 0) {
      left = 0;
    }
    //alert(left);
    jQuery('#max_char_limit_contact_form').html('- ' + left + ' character count');
  });

//  jQuery('.node-type-webform #container-top-bar').attr('id', 'contact-page-content');
  //jQuery("#boxscroll").niceScroll("#contentscroll2",{cursorcolor:"#aaaaaa",cursoropacitymax:1,boxzoom:true,touchbehavior:true});

  jQuery('.node-webform .user-picture').html('');
  jQuery('#opener').on('click', function() {
    var panel = jQuery('#slide-panel');
    if (panel.hasClass("visible")) {
      panel.removeClass('visible').animate({'margin-right': '-300px'});
    } else {
      panel.addClass('visible').animate({'margin-right': '0px'});
    }
    return false;
  });


  // Dharmesh Patel changes end

  //Vishal Shah changes starts here
  jQuery("select, input, a.button").uniform();


  /*Code to manage add and remove of interests under profile page starts here*/
  jQuery("#edit-profile-your-interest-field-interests-und").chosen({
    no_results_text: "Oops, nothing found!",
    width: "300px",
    enable_search_threshold: 10
  }).change(function(event) {
    jQuery('#interest_user').append('<li><a><img src="/sites/all/themes/local_fixer/images/in-cross.png"/></a>' + jQuery('.search-choice:first').text() + '</li>');
    jQuery('.search-choice').remove();
  });

  jQuery("#edit_profile_main_field_interests_und_chosen ul li").each(function() {
    if (!(jQuery(this).text() == ""))
    {
      jQuery('#interest_user').append('<li><a><img src="/sites/all/themes/local_fixer/images/in-cross.png"/></a>' + jQuery(this).text() + '</li>');
    }
  });

  jQuery(document).on('click', '#interest_user li a', function() {
    txt = jQuery(this).closest('li').text();
    jQuery('#edit-profile-your-interest-field-interests-und option:contains(' + txt + ')').removeAttr('selected');
    jQuery(this).closest('li').remove();
    jQuery("#edit-profile-your-interest-field-interests-und").trigger("chosen:updated");
    jQuery('.search-choice').remove();
  })
  /*Code to manage add and remove of interests under profile page Ends here*/

  /*Code to manage add and remove of interests under Add review page starts here*/
  jQuery("#edit-field-reivew-interest-und").chosen({
    no_results_text: "Oops, nothing found!",
    width: "300px",
    enable_search_threshold: 10
  }).change(function(event) {
    jQuery('#interest_user').append('<li><a><img src="/sites/all/themes/local_fixer/images/in-cross.png"/></a>' + jQuery('.search-choice:first').text() + '</li>');
    jQuery('.search-choice').remove();
  });

  jQuery("#edit_profile_main_field_interests_und_chosen ul li").each(function() {
    if (!(jQuery(this).text() == ""))
    {
      jQuery('#interest_user').append('<li><a><img src="/sites/all/themes/local_fixer/images/in-cross.png"/></a>' + jQuery(this).text() + '</li>');
    }
  });

  jQuery(document).on('click', '#interest_user li a', function() {
    txt = jQuery(this).closest('li').text();
    jQuery('#edit-field-reivew-interest-und option:contains(' + txt + ')').removeAttr('selected');
    jQuery(this).closest('li').remove();
    jQuery("#edit-field-reivew-interest-und").trigger("chosen:updated");
    jQuery('.search-choice').remove();
  })
  /*Code to manage add and remove of interests under Add review page Ends here*/

  setTimeout(function() {
    jQuery('.search-choice').remove();
  }, 100);


  /*Code to open image upload starts here */
  function open_image_upload() {
    //jQuery('#edit-picture-upload').click();
    jQuery('#edit-picture-upload').click();
  }
  /*Code to open image upload ends here */


  /* JS for Message disappearance starts here */
  setTimeout(function() {
    if (jQuery("#messages_reg").length)
    {
      //jQuery("#messages_reg").hide(1000);
    }
  }, 2000);

  /* JS for Message disappearance ends here */

  jQuery('#horizontalTab').easyResponsiveTabs({
    type: 'default', //Types: default, vertical, accordion           
    width: 'auto', //auto or any width like 600px
    fit: true, // 100% fit in a container
    closed: 'accordion', // Start closed if in accordion view
    activate: function(event) { // Callback function if tab is switched
      var $tab = jQuery(this);
      var $info = jQuery('#tabInfo');
      var $name = jQuery('span', $info);

      $name.text($tab.text());

      $info.show();
    }
  });
//Vishal Shah changes starts here

  jQuery('.down-arrow').click(function() {
    var rel = jQuery(this).attr('href');
    if (rel === '#container-bottom-bar') {
      jQuery('html, body').animate({
        scrollTop: jQuery('div[class=footer-menu]').offset().top
      }, 500);
    }
  });

  jQuery('.top-arrow').click(function() {
    var rel = jQuery(this).attr('href');
    if (rel === '#container-top-bar') {
      jQuery('html, body').animate({
        scrollTop: jQuery('section[id=container-top-bar]').offset().top - 80
      }, 500);
    }
  });

  jQuery('.msg-smiley').click(function() {
    //alert(jQuery('.msg-smiley').css('display'));
    if (jQuery('#emoticons').is(':visible')) {
      jQuery('#emoticons').hide();
    } else {
      jQuery('#emoticons').show();
    }
  });

  jQuery('#emoticons a').click(function() {
    var smile_sttr = jQuery(this).attr('title');
    var get_exist_html = jQuery("#edit-body").val();
    jQuery("#edit-body").val(get_exist_html + "" + smile_sttr);
  });

  //Code for write a review page
  jQuery('.field-name-field-review-location .panel-body').removeClass();

  //Code for seach for radius on maps and search listing
  jQuery('#views-exposed-form-search-reviews-page-1 #edit-field-geofield-distance').addClass('filter-form');
  jQuery('#views-exposed-form-search-reviews-page-1 #edit-field-geofield-distance #edit-field-geofield-distance-distance').addClass('default-input ');

  jQuery("#views-exposed-form-search-reviews-page-1 #edit-field-review-location-locality").keyup(function() {
    jQuery('#views-exposed-form-search-reviews-page-1 #edit-field-geofield-distance-origin').val((jQuery(this).val()));
  });

  jQuery('#views-exposed-form-openlayers-data-overlay-page-2 #edit-field-geofield-distance').addClass('filter-form');
  jQuery('#views-exposed-form-openlayers-data-overlay-page-2 #edit-field-geofield-distance #edit-field-geofield-distance-distance').addClass('default-input ');

  jQuery("#views-exposed-form-openlayers-data-overlay-page-2 #edit-field-review-location-locality").keyup(function() {
    jQuery('#views-exposed-form-openlayers-data-overlay-page-2 #edit-field-geofield-distance-origin').val((jQuery(this).val()));
  });
});