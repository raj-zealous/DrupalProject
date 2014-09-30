<?php
/**
 * @file
 * Default theme implementation to provide an HTML container for comments.
 *
 * Available variables:
 * - $content: The array of content-related elements for the node. Use
 *   render($content) to print them all, or
 *   print a subset such as render($content['comment_form']).
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default value has the following:
 *   - comment-wrapper: The current template type, i.e., "theming hook".
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * The following variables are provided for contextual information.
 * - $node: Node object the comments are attached to.
 * The constants below the variables show the possible values and should be
 * used for comparison.
 * - $display_mode
 *   - COMMENT_MODE_FLAT
 *   - COMMENT_MODE_THREADED
 *
 * Other variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess_comment_wrapper()
 *
 * @ingroup themeable
 */
global $base_url, $user;

$path = $base_url . '/' . path_to_theme();
?>
<div id="comments" class="<?php print $classes; ?>"<?php print $attributes; ?>>
    <?php if ($content['comments'] && $node->type != 'forum'): ?>
        <?php print render($title_prefix); ?>
                                                                            <!--    <h2 class="title"><?php //print t('Comments');                 ?></h2>-->
        <?php print render($title_suffix); ?>
    <?php endif; ?>

    <div class="container">
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="comment-section">
                    <div class="comment-title clearfix">
                        <h3>Post A Comment</h3>
                        <div class="comment-counter">
                            <strong><?php print $node->comment_count ?></strong> <?php print t('Comments'); ?>
                        </div>
                    </div>

                    <div class="comment-content">
                        <?php
                        //pa($content['comments']);
                        print render($content['comments']);
                        
                        ?>
                    </div>
          <?php if (user_is_logged_in()) { ?>
                    <?php if ($content['comment_form']): ?>
                        <div class="leave-comment-box">
                            <div class="leave-title">Leave a Comment</div>
                            <h2 class="title comment-form" style ="display:none;"><?php print t('Add new comment'); ?></h2>

                            <div class="leave-content">
                                <div class="main-comment">
                                    <div class="comment_container clearfix">

                                        <?php
                                        $user_i = user_load($user->uid);
                                        $u_image = file_create_url($user_i->picture->uri);
                                        ?>
                                        <div class="user-image">
                                            <img width="76" height="76" src="<?php print $u_image ?>"></div>
                                        <div>
            <!--    <h2 class="title comment-form"><?php //print t('Add new comment');                 ?></h2>-->
                                            <?php print render($content['comment_form']); ?>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
          <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>