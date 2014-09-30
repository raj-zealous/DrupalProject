<?php
/**
 * @file
 * Customize the display of a complete webform.
 *
 * This file may be renamed "webform-form-[nid].tpl.php" to target a specific
 * webform on your site. Or you can leave it "webform-form.tpl.php" to affect
 * all webforms on your site.
 *
 * Available variables:
 * - $form: The complete form array.
 * - $nid: The node ID of the Webform.
 *
 * The $form array contains two main pieces:
 * - $form['submitted']: The main content of the user-created form.
 * - $form['details']: Internal information stored by Webform.
 */
?>
<?php
//drupal_add_css(path_to_theme() . '/css/uniform.default.css', array('group' => CSS_THEME)); 
global $base_url;
$theme_path = $base_url . '/' . path_to_theme();
//pa($theme_path);
?>
<div class="contact-top-box text-center">
  <div class="contact-icon-top"><img src="<?php print $theme_path ?>/images/contact-icon1.png" class="img-responsive"></div>
  <div class="contact-text1 clearfix">Before contating support , have you seen our</div>
  <div class="contact-text2 clearfix">frequently asked questions?</div>
  <div class="contact-text3 clearfix">We have a short list of most frequently asked questions. For more information about Local Fixer, or for 
    custom supportm please open a support ticket. Visit our <a href="<?php print $base_url ?>/content/static-page">frequently asked questions.</a></div>
</div>


<div class="contact-form-box text-center">
  <div class="contact-icon"><img src="<?php print $theme_path ?>/images/contact-icon2.png" class="img-responsive"></div>
  <div class="contact-form-section">
    <div class="contact-title">
      <span>Contact Support</span>
    </div>
    <?php
//pa($form);
//print drupal_render($form['submitted']);
    ?>
    <div class="contact-form">
      <div class="row clearfix">
        <div class="col-sm-6">
          <div class="contact-form-left">
            <div class="form-field-box">
              <?php print drupal_render($form['submitted']['which_field_best_describes_your_problem']) ?>
              <!--                            <div class="label-title">Which field best describes your problem?</div>
                                          <select>
                                              <option>Country</option>
                                              <option>India</option>
                                              <option>USA</option>
                                              <option>Germany</option>
                                              <option>Canada</option>
                                          </select>-->
            </div>

            <div class="form-field-box">
              <div class="row clearfix">
                <div class="col-sm-6">
                  <?php print drupal_render($form['submitted']['first_name']) ?>
                  <!--                                    <div class="label-title">First Name*</div>
                                                      <input type="text" placeholder="Name*" class="default-input"/>-->
                </div>

                <div class="col-sm-6">
                  <?php print drupal_render($form['submitted']['last_name']) ?>
                  <!--                                    <div class="label-title">Last Name*</div>
                                                      <input type="text" placeholder="Last Name*" class="default-input"/>-->
                </div>
              </div>
            </div>

            <div class="form-field-box">
              <div class="row clearfix">
                <div class="col-sm-6">
                  <?php //pa($form);?>
                  <?php print drupal_render($form['submitted']['e_mail_address']) ?>
                  <!--                                    <div class="label-title">Email Address*</div>
                                                      <input type="text" placeholder="Email Address*" class="default-input"/>-->
                </div>

                <div class="col-sm-6">
                  <?php print drupal_render($form['submitted']['contact_no']) ?>
                  <!--                                    <div class="label-title">Last Name*</div>
                                                      <input type="text" placeholder="Last Name*" class="default-input"/>-->
                </div>
              </div>
            </div>


          </div>
        </div>
        <div class="col-sm-6">
          <div class="contact-form-right">
            <div class="form-field-box">
              <?php print drupal_render($form['submitted']['describe_your_problem_here']) ?>
              <span id="max_char_limit_contact_form">- 500 character count</span>
              <!--                            <div class="label-title">Describe your problem here:</div>
                                          <textarea placeholder=""></textarea>
                                          <span>- 500 character count</span>-->
            </div>

            <div class="form-field-box clearfix">
              <div class="continue">
                <?php
                //$form['submitted']['#attributes'] = array('class' => 'btn-orange');
                print drupal_render_children($form);
                //$form['actions']['submit']['#attributes'] = array('class' => 'my_class'); 
                ?>
                <!--                                <button class="btn-orange" type="submit">Send Message</button>-->

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>


  </div>
</div>

<div class="container">
  <div class="row clearfix">
    <div class="contact-title2 text-center">
      Your city of choice isn't available? No worries!
    </div>
  </div>
</div>

