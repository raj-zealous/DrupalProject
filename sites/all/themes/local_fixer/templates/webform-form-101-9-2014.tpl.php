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
<?php //drupal_add_css(path_to_theme() . '/css/uniform.default.css', array('group' => CSS_THEME)); 
global $base_url;
$theme_path = $base_url . '/' . path_to_theme();
//pa($theme_path);
?>
<div class="contact-top-box text-center">
    <div class="contact-icon-top"><img src="<?php print $theme_path?>/images/contact-icon1.png" class="img-responsive"></div>
    <div class="contact-text1 clearfix">Before contating support , have you seen our</div>
    <div class="contact-text2 clearfix">frequently asked questions?</div>
    <div class="contact-text3 clearfix">We have a short list of most frequently asked questions. For more information about Local Fixer, or for 
        custom supportm please open a support ticket. Visit our <a href="#">frequently asked questions.</a></div>
</div>


<div class="contact-form-box text-center">
    <div class="contact-icon"><img src="<?php print $theme_path?>/images/contact-icon2.png" class="img-responsive"></div>
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
                            <?php print drupal_render($form['submitted']['which_field_best_describes_your_problem'])?>
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
                                    <?php print drupal_render($form['submitted']['first_name'])?>
<!--                                    <div class="label-title">First Name*</div>
                                    <input type="text" placeholder="Name*" class="default-input"/>-->
                                </div>

                                <div class="col-sm-6">
                                     <?php print drupal_render($form['submitted']['last_name'])?>
<!--                                    <div class="label-title">Last Name*</div>
                                    <input type="text" placeholder="Last Name*" class="default-input"/>-->
                                </div>
                            </div>
                        </div>

                        <div class="form-field-box">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <?php //pa($form);?>
                                    <?php print drupal_render($form['submitted']['e_mail_address'])?>
<!--                                    <div class="label-title">Email Address*</div>
                                    <input type="text" placeholder="Email Address*" class="default-input"/>-->
                                </div>

                                <div class="col-sm-6">
                                    <?php print drupal_render($form['submitted']['contact_no'])?>
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
                            <?php print drupal_render($form['submitted']['describe_your_problem_here'])?>
                            <span>- 500 character count</span>
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

<div class="contact-form-box2 text-center">

    <div class="contact-form-section2">
        <div class="contact-heading1">If you're a <span>local</span></div>
        <div class="contact-text">Start sharing and quickly become known as the go to fixer in your city! The more you share, the more connected you will be!</div>
        <div class="sharing-btn">
            <button class="btn-orange" type="submit">Start Sharing!</button>
        </div>
    </div>


    <div class="contact-form-section2">
        <div class="contact-heading1">If you're a <span>Traveller</span></div>
        <div class="contact-text4">Make sure to contact us, so we can <i>fix</i> you up with locals from our global network, who will <i>fix</i> you up with the local knowledge you need! Provide us with a brief description of where you are going and what you are interested in discovering, and we'll make sure to connect you to likeminded fixers!</div>


        <div class="contact-form2">
            <div class="row clearfix">

                <div class="form-field-box">
                    <div class="clearfix">
                        <div class="col-sm-6">

                            <input type="text" placeholder="Where are you going..." class="default-input uniform-input text hover">
                        </div>

                        <div class="col-sm-6">

                            <input type="text" placeholder="What are you interested in discovering..." class="default-input uniform-input text">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="sharing-btn">
            <button class="btn-orange" type="submit">Send it!</button>
        </div>
    </div>


</div>




<?php
//echo "<pre>";
//pa($form);
//exit;
// Print out the main part of the form.
// Feel free to break this up and move the pieces within the array.
//print drupal_render($form['submitted']);
// Always print out the entire $form. This renders the remaining pieces of the
// form that haven't yet been rendered above.
//print drupal_render_children($form);
?>

