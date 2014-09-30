<?php
/**
 * @file
 * This template is used to print a single field in a view.
 *
 * It is not actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the template is
 * perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */
global $base_url;
//echo '<pre>';print_r($row);die;
?>
<div class="col-sm-3">
  <div class="picture">
    <a href="<?php print $base_url . "/node/" . $row->nid ?>"><?php print render($row->field_field_review_images[0]['rendered']) ?></a>
  </div>
</div>
<div class="col-sm-9">
  <div class="list-data">
    <div class="list-heading clearfix">
      <div class="list-title"><a href="<?php print $base_url . "/node/" . $row->nid ?>"><?php print render($row->node_title); ?></a><span class="list-date"><?php print format_date($row->node_created, "custom", "M d, Y") ?></span></div>
      <div class="list-ratings">
        <?php print render($row->field_field_review_ratings[0]['rendered']) ?>
      </div>
    </div>
    <div class="list-location">
      Located in <?php print render($row->field_data_field_review_location_field_review_location_premi) ?> <?php print render($row->field_data_field_review_location_field_review_location_thoro) ?> , 
      <?php print render($row->field_data_field_review_location_field_review_location_local) ?> <?php print render($row->field_data_field_review_location_field_review_location_admin) ?>
    </div>
    <div class="list-text">
      <?php print render($row->field_field_review_description[0]['rendered']) ?>
    </div>

    <div class="list-category clearfix">
      <div class="category-text"><?php print render($row->field_field_reivew_interest[0]['rendered']) ?></div>
      <div class="travel-exp"><span><?php print render($row->field_field_review_type[0]['rendered']) ?></span>
        <div class="a2a_kit">
          <ul>
            <li class="facebook"><a class="a2a_button_facebook pf-fb"></a></li>
            <li class="twitter"><a class="a2a_button_twitter pf-twitter"></a></li>
            <li class="google"><a class="a2a_button_google_plus pf-gplus"></a></li>
          </ul>
        </div>
      </div>

      <script type="text/javascript">
        var a2a_config = a2a_config || {};
        a2a_config.linkname = '<?php print $row->node_title; ?>';
        a2a_config.linkurl = '<?php print $base_url . "/node/" . $row->nid ?>';
      </script>
      <script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>      
    </div>
  </div>
</div>
</div>


<?php //print $output; ?>
