<?php
/**
 * @file
 * Default theme implementation for comments.
 *
 * Available variables:
 * - $author: Comment author. Can be link or plain text.
 * - $content: An array of comment items. Use render($content) to print them all, or
 *   print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $created: Formatted date and time for when the comment was created.
 *   Preprocess functions can reformat it by calling format_date() with the
 *   desired parameters on the $comment->created variable.
 * - $changed: Formatted date and time for when the comment was last changed.
 *   Preprocess functions can reformat it by calling format_date() with the
 *   desired parameters on the $comment->changed variable.
 * - $new: New comment marker.
 * - $permalink: Comment permalink.
 * - $submitted: Submission information created from $author and $created during
 *   template_preprocess_comment().
 * - $picture: Authors picture.
 * - $signature: Authors signature.
 * - $status: Comment status. Possible values are:
 *   comment-unpublished, comment-published or comment-preview.
 * - $title: Linked title.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - comment: The current template type, i.e., "theming hook".
 *   - comment-by-anonymous: Comment by an unregistered user.
 *   - comment-by-node-author: Comment by the author of the parent node.
 *   - comment-preview: When previewing a new or edited comment.
 *   The following applies only to viewers who are registered users:
 *   - comment-unpublished: An unpublished comment visible only to administrators.
 *   - comment-by-viewer: Comment by the user currently viewing the page.
 *   - comment-new: New comment since last the visit.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * These two variables are provided for context:
 * - $comment: Full comment object.
 * - $node: Node object the comments are attached to.
 *
 * Other variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess()
 * @see template_preprocess_comment()
 * @see template_process()
 * @see theme_comment()
 *
 * @ingroup themeable
 */
//pa($node);
?>
<div class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <?php //print $picture ?>


    <?php // print render($title_prefix); ?>
<!--  <h3<?php //print $title_attributes;             ?>><?php //print $title           ?></h3>-->
    <?php //print render($title_suffix); ?>

    <div class="submitted">
        <?php //print $permalink;  ?>
        <?php //print $submitted; ?>
    </div>

    <div class="content"<?php print $content_attributes; ?>>
        <?php
        // We hide the comments and links now so that we can render them later.
        hide($content['links']);
        //print render($content);
        ?>
        <div class="main-comment">
            <div class="comment_container clearfix">
                <div class="user-image">
                    <img src="<?php print $user_image; ?>" width="76" width="76"  alt="">
                </div>
                <div>
                    <div class="comment_info">
                        <p class="post_title">
                        <div class="author_post clearfix"> <?php print $user_first_name ?> <span class="date_post"><?php print $comment_date; ?></span></div> 
                        <div class="location_post"><?php print $location; ?></div>
                        </p>
                    </div>
                    <p class="comment-text">
                        <?php
                        print render($content);
                        ?>                        
                    </p>
                </div>
                <!--                <a class="reply-link" href="#">+ REPLY</a>-->
                <?php print render($content['links']) ?>

            </div>
        </div>
        <?php if ($signature): ?>
            <div class="user-signature clearfix">
                <?php //print $signature   ?>
            </div>
        <?php endif; ?>
    </div>

    <?php //print render($content['links'])  ?>
</div>
