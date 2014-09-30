/*Created By : Shubham Porwal*/
var $ = jQuery.noConflict();
/*Document ready starts here*/
$(document).ready(function() {
  $('.a-scroll').smoothScroll(
  {
    offset: -77,
  });
  $('.mag-video').magnificPopup({
    disableOn: 700,
    type: 'iframe',
    mainClass: 'mfp-fade',
    removalDelay: 160,
    preloader: false,
    
    fixedContentPos: false
  });
        
  if (Modernizr.touch) {
    //console.log('yes');
    $('.btns-circle').hide();
  }
    	
  /*jQuery code to show active menu in main menu*/	
  var value_node = jQuery('#hidden_value').attr('value');
  jQuery('.li_'+value_node).addClass("active");
  jQuery('.navbar-fixed-top .header .navbar-nav li').click(function (){		
    jQuery(".navbar-fixed-top .header .navbar-nav li").removeClass("active");
    jQuery(this).addClass("active");
	
  });
     	
  /*Code to add custom rule to validate phone number Starts here*/ 
  jQuery.validator.addMethod("phoneNumber", function(value, element) {
    return this.optional(element) || /^[0-9\.\-\+]+$/.test(value);
  }, "Please Enter Correct Phone Number");
  /*Code to add custom rule to validate phone number Ends here*/
		
  /*Code to add custom rule to validate phone number Starts here*/ 
  jQuery.validator.addMethod("firstname", function(value, element) {
    return this.optional(element) || /^[A-Za-z]+(( [A-Za-z]+)|('[A-Za-z]+)|( +))*$/.test(value);
  }, "Please Enter Correct first name");
  /*Code to add custom rule to validate phone number Ends here*/
		
  /*Code to add custom rule to validate phone number Starts here*/ 
  jQuery.validator.addMethod("lastname", function(value, element) {
    return this.optional(element) || /^[A-Za-z]+(( [A-Za-z]+)|('[A-Za-z]+)|( +))*$/.test(value);
  }, "Please Enter Correct last name");
  /*Code to add custom rule to validate phone number Ends here*/
		
  /*Code to add custom rule to validate Address Starts here*/ 
  jQuery.validator.addMethod("Address", function(value, element) {
    return this.optional(element) || /^[\/\A-Za-z0-9 \#\(\)\,\-]+$/.test(value);
  }, "Please Enter Correct Address");
  /*Code to add custom rule to validate Address Ends here*/
		
  /*Code to add custom rule to validate Address Starts here*/ 
  jQuery.validator.addMethod("city", function(value, element) {
    return this.optional(element) || /^[\/\A-Za-z]+(( [A-Za-z]+)|(.[A-Za-z]+))+( +)*$/.test(value);
  }, "Please Enter Correct City");
  /*Code to add custom rule to validate Address Ends here*/
		
  /*Code to add custom rule to validate Address Starts here*/ 
  jQuery.validator.addMethod("state", function(value, element) {
    return this.optional(element) || /^[\/\A-Za-z]+(( [A-Za-z]+)|(.[A-Za-z]+))+( +)*$/.test(value);
  }, "Please Enter Correct State");
  /*Code to add custom rule to validate Address Ends here*/
		
  /*Code to add custom rule to Match Password Starts here*/
  jQuery.validator.addMethod("confirmationPass", function(value, element, params) {	
    if(value == params)
    {
      return true;
    }
    else
    {
      return false;
    }
		   
  }, 'password not match');
		
  /*Code to add custom rule to Match Password Ends here*/
  jQuery.validator.addMethod("checkNone", function(value, element, params) {	
    var a = params.split(",");
    console.log(a[0]);
    if(value == '_none' || a[0] == '_none' || a[1] == '_none' )
    {
      return false;
    }
    else
    {
      return true;
    }
		   
  }, 'Required');

		
  /*function to validate different forms*/
  /*when the dom has loaded setup form validation rules*/ 
  (function($,W,D)
  {
    var JQUERY4U = {};
		
    JQUERY4U.UTIL =
    {
      setupFormValidation: function()
      {
        //form validation rules
        $("#user-profile-form").validate({
          errorElement: "div",
          errorClass: "cust_error",
          errorPlacement: function(error, element) {
            error.appendTo(element.closest(".append_error"));
          },
          rules: {
            "profile_main[field_name][und][0][value]" :{
              required: true,
              firstname: true,
              minlength: 3,
              maxlength: 15                       	 	
            },
            "mail" : {
              required: true,
              email: true
            },
            "pass[pass2]" :{
              equalTo: '#edit-pass-pass1'
            },
            "profile_main[field_year][und]":{
              checkNone: function(){
                return $('#edit-profile-main-field-day-und').val()+','+$('#edit-profile-main-field-month-und').val();
              }
            },
            "profile_main[field_country][und][0][value]" :{
              required: true						
            },
            "profile_main[field_city][und][0][value]" :{
              required: true,
              city: true,
              minlength: 3						
            },
            "profile_main[field_postcode][und][0][value]" :{
              required: true,
              digits:true,
              number:true,
              minlength: 4,
              maxlength: 10						
            },
            "profile_main[field_interests][und][]" :{
              required: true
            }
							
          },
          messages: {
            "profile_main[field_name][und][0][value]":
            {
              "required":"Please enter Your Name",
              "firstname":"Enter Valid Name",
              "minlength":"Name should be minimum of 3 characters",
              "maxlength":"Name should not exceed 15 characters"
            },
            "mail": 
            {
              "required":"Please enter Your Mail Address",
              "email":"Please enter a valid email address"
            },
            "pass[pass2]": "Password and confirm password do not match",
            "profile_main[field_year][und]": "Please set Date of birth",
            "profile_main[field_postcode][und][0][value]":{
              "required":"Please Enter Postcode",
              "digits":"Please Enter valid Postcode",
              "number":"Please Enter valid Postcode"
            }
							
          },
          submitHandler: function(form) {
            form.submit();
          }
        });
      }
    }
			
    $(document).ready(function($) {
      //console.log("setupFormValidation");
      JQUERY4U.UTIL.setupFormValidation();
    });   
		
  })(jQuery, window, document);
  /*function to validate different web form Ends here*/
 		
  /*Code to triger Login Modal*/	   
  $(document).on("click",".triger_login",function(){
    $("#login_link").click();
    $("#form_links").html('<span class="col-sm-offset-my">'
      +'<a href="javascript:void(0)" class="popup-left-link triger_password">Forgot password?</a>'
      +'</span>'
      +'<span class="col-sm-offset-my link-float">'
      +'<a href="javascript:void(0)" class="popup-left-link triger_register">Don\'t have an account?<span class="color"> Get Started<'
      +'/span></a>'
      +'</span>');
		
    $(".wrapper-div,.footer-main").css("display","none");
		
  });
	   
  /*Code to triger Forgot Password Modal*/
  $(document).on("click",".triger_password",function(){
    $("#password_link").click();
    $("#logo_text").html('<h2 style="color:#333;">Forgotten password</h2>'
      +'<p style="color:#333;">Enter your email address to retrieve your password</p>');
    $("#form_links").html('<span class="col-sm-offset-my link-float">'
      +'<a href="javascript:void(0)" class="popup-left-link triger_login">I know my password?<span class="color"> Login<'
      +'/span></a>'
      +'</span>');   
		
  });
	   
  /*Code to triger Registration Modal*/
  $(document).on("click",".triger_register",function(){
    $("#register_link").click();
    $("#logos_fb").attr("src","sites/all/themes/local_fixer/images/singup_login.png");
    $("#form_links").html('<span class="col-sm-offset-my link-float">'
      +'<a href="javascript:void(0)" class="popup-left-link triger_login">Have an account?<span class="color"> Login<'
      +'/span></a>'
      +'</span>');
    $(".wrapper-div,.footer-main").css("display","none");
  });
	    
  /*Code to Apply Chosen.js for drop downs*/
  /* This line of code is not in use
		*Select.init({selector: '.select_js .form-select'});
	*/
  $("#edit-profile-main-field-day-und").chosen({
    disable_search_threshold:100
  });
  $("#edit-profile-main-field-month-und").chosen({
    disable_search_threshold:100
  });
  $("#edit-profile-main-field-year-und").chosen({
    disable_search_threshold:200
  });
  $("#edit-profile-main-field-country-und").chosen();
  $("#search-location").chosen();
  $("#search-interests").chosen({
    disable_search_threshold:200
  });
  $("#search-gender").chosen({
    disable_search_threshold:200
  });
	
  /*Code to manage add and remove of interests under profile page starts here*/
  $("#edit-profile-main-field-interests-und").chosen({
    no_results_text: "Oops, nothing found!",
    width: "300px",
    enable_search_threshold: 10,
  }).change(function(event){
    $('#interest_user').append('<li><a><img src="./sites/all/themes/local_fixer/images/in-cross.png"/></a>'+$('.search-choice:first').text()+'</li>');
    $('.search-choice').remove();
  });
	
  $("#edit_profile_main_field_interests_und_chosen ul li").each(function(){
    if(!($(this).text()==""))
    {
      $('#interest_user').append('<li><a><img src="./sites/all/themes/local_fixer/images/in-cross.png"/></a>'+$(this).text()+'</li>');
    }
  });
	
  //$("#edit-profile-main-field-interests .search-field input[type='text']").attr("placeholder","Select some interests");
	
  setTimeout(function(){
    $('.search-choice').remove();
  },100);
	
  $(document).on('click','#interest_user li a',function(){
    txt=$(this).closest('li').text();
    $('#edit-profile-main-field-interests-und option:contains('+txt+')').removeAttr('selected');
    $(this).closest('li').remove();
    $("#edit-profile-main-field-interests-und").trigger("chosen:updated");
    $('.search-choice').remove();
  })
  /*Code to manage add and remove of interests under profile page Ends here*/
	
  /*Code to toogle logout div  */
  $(document).on("click","#toogle_logout",function(event){
    event.stopPropagation();
    $("#log_profile").slideToggle();
  });
	
  $(document).on("click","#toogle_logout_m",function(event){
    event.stopPropagation();
    $("#log_profile_m").slideToggle();
  });
  /*Code to toogle logout div  */
	
  /*Code to show Profile picture on selecting image from profile page Starts here*/
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
            
      reader.onload = function (e) {
        $('#profile_pic').attr('src', e.target.result);
      }
            
      reader.readAsDataURL(input.files[0]);
    }
  }
    
  $("#edit-picture-upload").change(function(){      
    readURL(this);
  });
  /*Code to show Profile picture on selecting image from profile page Ends here*/
	
	
  $('#filter_form :checkbox').change(function(){
    $("#filter_form").submit();
  });
	  
});
/*Document ready Ends here*/
    
/*Code to load body with animation*/
$(window).load(function() {
  $('body').animate({
    'opacity'   : 1
  }, 500, function() {
    $(window).resize(function() {
      var winh = $(window).height();
                
      $('.fullheight .fullheight-pad').css({
        'padding-top'   : '',
        'padding-bottom': ''
      });
                
      $('.fullheight').each(function() {
        var curh =  $(this).height();
        var thispad = parseInt($(this).css('padding-top')) + parseInt($(this).css('padding-bottom'));
                    
        var pad = (winh - $('.fullheight-pad', this).height() - $('.btn-next', this).height() - $('.btn-prev', this).height() - $('.btn-next-ff', this).height() - $('.btn-prev-ff', this).height() - thispad) / 2;
        //console.log(curh + ' ' + winh);
        //console.log(winh + ' ' + $('.fullheight-pad', this).height() + ' ' + $('.btn-next', this).height() + ' ' + $('.btn-prev', this).height() + ' ' + $('.btn-next-ff', this).height() + ' ' + $('.btn-prev-ff', this).height());
        //console.log(pad);
                    
        if (curh < winh) {
                        
          $('.fullheight-pad', this).css({
            'padding-top'   : pad + 'px',
            'padding-bottom': pad + 'px'
          });
        } 
      });
    }).resize();
            
    $('[data-bg]').each(function() {
      //$(this).css('background-image', "url('" + $(this).data('bg') + "')");
      })
  })
        
        
  if (!isTouchDevice())
    $(window).scroll(function() {
      var $window = $(this);
      var maxshare = 0;
      var $activelink;
      if($('.btn-circle').length)
      {
        $('.btn-circle').each(function() {
          var $self = $($(this).attr('href')),
          // var $self = $(this),
          offsetCoords = $self.offset(),
          topOffset = offsetCoords.top;
    
          //if (($window.scrollTop() + $window.height()) > (topOffset) && ((topOffset + $self.height()) > $window.scrollTop()))
    
          if (topOffset >= $window.scrollTop())
            var share = Math.min(topOffset + $self.height(), $window.scrollTop() + $window.height()) - topOffset;
          else
          if (topOffset + $self.height() > $window.scrollTop())
            var share = topOffset + $self.height() - $window.scrollTop();
    
                    
    
          //console.log($self.attr('data-page-slug') + ' ' + $self.attr('data-page-id') + ' ' + share);
    
          if (share > maxshare)
          {
            maxshare = share;
            $activelink = $(this);
          //maxslug = $self.attr('data-page-slug');
          //maxid = $self.attr('data-page-id');
          }
                    
        //console.log($(this).attr('href') + ' ' + share);
        //console.debug($activelink);
        });
                
        $('.btn-circle').removeClass('active');
        if(typeof $activelink != "undefined")
          $activelink.addClass('active');
      }
    }).scroll();
})
