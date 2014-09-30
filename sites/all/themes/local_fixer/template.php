<?php

/**
 * @file
 * template.php
 */

/**
 * Overrides theme_breadcrumb().
 *
 * Print breadcrumbs as an ordered list.
 */
function local_fixer_breadcrumb($variables) {
  $output = '';
  $breadcrumb = $variables['breadcrumb'];

  // Determine if we are to display the breadcrumb.
  $bootstrap_breadcrumb = theme_get_setting('bootstrap_breadcrumb');
  if (($bootstrap_breadcrumb == 1 || ($bootstrap_breadcrumb == 2 && arg(0) == 'admin')) && !empty($breadcrumb)) {
    $output = theme('item_list', array(
      'attributes' => array(
        'class' => array('breadcrumb'),
      ),
      'items' => $breadcrumb,
      'type' => 'ol',
    ));
  }
  return $output;
}

/**
 * Implements hook_preprocess_page().
 *
 * @see page.tpl.php
 */
function local_fixer_preprocess_page(&$variables) {

  $args = arg();

  if (drupal_is_front_page()) {
    $variables['theme_hook_suggestions'][] = 'page__front';
    $variables['title'] = "";
    unset($variables['page']['content']['system_main']['default_message']);
  } else if (isset($variables['node']->type)) {
    $variables['theme_hook_suggestions'][] = 'page__' . $variables['node']->type;
    if (!empty($args[0]) && !empty($args[1])) {
      if ($args[0] == 'node' && $args[1] == 21) {
        $variables['theme_hook_suggestions'][] = 'page__fixer_locations';
      }
      if ($args[0] == 'node' && $args[1] == 61) {
        $variables['theme_hook_suggestions'][] = 'page__faq';
      }
      if ($args[0] == 'node' && $args[1] == 10) {
        $variables['theme_hook_suggestions'][] = 'page__contact_support';
      }
      if ($args[0] == 'node' && ($args[1] == 3 || $args[1] == 4 || $args[1] == 5)) {
        $variables['theme_hook_suggestions'][] = 'page__static_page';
        $variables['title'] = '';
      }
      if ($args[0] == 'node' && !empty($args[1]) && !empty($args[2]) && $args[2] == 'delete') {
        $variables['theme_hook_suggestions'][] = 'page__review_delete';
        $variables['title'] = '';
      }
    }
  }
  else if ($args[0] == 'send_message_to_friend') {
        $variables['theme_hook_suggestions'][] = 'page__my-messages';
        $variables['title'] = '';
    }
	
  /*echo '<pre>';
  print_r($variables);die();*/

}

/**
 * Implements hook_process_page().
 *
 * @see page.tpl.php
 */
function local_fixer_process_page(&$variables) {
  //echo '<pre>';print_r($variables['theme_hook_suggestions']);die;
  $variables['navbar_classes'] = implode(' ', $variables['navbar_classes_array']);
}

/**
 * Override the submitted variable.
 */
function local_fixer_preprocess_node(&$variables) {
  $args = arg();
  if (isset($variables['node']->type)) {
    $variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->type;
    $variables['submitted'] = '';
  }

  if ($variables['view_mode'] == 'teaser') {
    $variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->type . '__teaser';
    if (!empty($args[0]) && $args[0] == 'written-reviews') {
      $variables['theme_hook_suggestions'][] = 'node__written_reviews__teaser';
    }
    if (!empty($args[0]) && $args[0] == 'saved-reviews') {
      $variables['theme_hook_suggestions'][] = 'node__saved_reviews__teaser';
    }
  }
//  echo '<pre>';print_r($variables['theme_hook_suggestions']);die;
}

/**
 * Overrides theme_menu_tree().
 */
function local_fixer_menu_tree(&$variables) {
  return '<ul class="menu">' . $variables['tree'] . '</ul>';
}

/**
 * Bootstrap theme wrapper function for the primary menu links.
 */
function local_fixer_menu_tree__primary(&$variables) {
  return '<ul class="nav navbar-nav">' . $variables['tree'] . '</ul>';
}

/**
 * Bootstrap theme wrapper function for the secondary menu links.
 */
function local_fixer_menu_tree__secondary(&$variables) {
  return '<ul class="menu nav navbar-nav navbar-right">' . $variables['tree'] . '</ul>';
}

function local_fixer_menu_link(&$variables) {

  $element = $variables['element'];
  $sub_menu = '';

  //echo '<pre>';print_r($element);die;
  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }

  if ($element['#theme'] == 'menu_link__menu_system') {
    //$str =  $element['#title']. substr($element['#href'], 5).'-block';
    $element['#attributes']['class'][] = 'col-lg-3 col-sm-3 col-md-3 col-xs-12';
    $output = l($element['#title'], $element['#href'], $element['#localized_options']);
    return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
  } else {

    $unread_msg_inbox = "";
    $message_type = 'message';
    $unread_msg_inbox = count(message_type_unread_count($message_type));

    if ($element['#title'] == t("My messages")) {
      if (!user_is_logged_in()) {
        $element['#attributes']['class'][] = 'hidden';
      }

      $element['#attributes']['class'][] = 'unread_msg_cont';
      $element['#title'] = $unread_msg_inbox . t(' My messages');
      // pa($element);
    }

    $output = l($element['#title'], $element['#href'], $element['#localized_options']);
    return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
  }
}

/**
 * Implementation theme_image_widget($variables)
 */
function local_fixer_image_widget($vars) {
  unset($vars['element']['upload_button'], $vars['element']['remove_button']);
  return theme_image_widget($vars);
}

function local_fixer_date_combo($variables) {
  return theme('form_element', $variables);
}

/**
 * Overrides theme_button().
 */
function local_fixer_button($variables) {
  $element = $variables['element'];
  $label = $element['#value'];
  element_set_attributes($element, array('id', 'name', 'value', 'type'));

  // If a button type class isn't present then add in default.
  $button_classes = array(
    'btn-default',
    'btn-primary',
    'btn-success',
    'btn-info',
    'btn-warning',
    'btn-danger',
    'btn-link',
  );
  $class_intersection = array_intersect($button_classes, $element['#attributes']['class']);
  if (empty($class_intersection)) {
    $element['#attributes']['class'][] = '';
  }

  // Add in the button type class.
  $element['#attributes']['class'][] = 'form-' . $element['#button_type'];

  // This line break adds inherent margin between multiple buttons.
  return '<button' . drupal_attributes($element['#attributes']) . '>' . $label . "</button>\n";
}

/**
 * Implements hook_element_info_alter().
 */
function local_fixer_element_info_alter(&$elements) {
  foreach ($elements as &$element) {
    // Process input elements.
    if (!empty($element['#input'])) {
      $element['#process'][] = '_local_fixer_process_input';
    }
  }
}

/**
 * Implements hook_preprocess_bootstrap_panel().
 */
function local_fixer_preprocess_bootstrap_panel(&$variables) {
  $element = &$variables['element'];
  $attributes = !empty($element['#attributes']) ? $element['#attributes'] : array();
  $attributes['class'][] = '';
  $attributes['class'][] = '';
  // states.js requires form-wrapper on fieldset to work properly.
  $attributes['class'][] = 'form-wrapper';
  $variables['collapsible'] = FALSE;
  if (isset($element['#collapsible'])) {
    $variables['collapsible'] = $element['#collapsible'];
  }
  $variables['collapsed'] = FALSE;
  if (isset($element['#collapsed'])) {
    $variables['collapsed'] = $element['#collapsed'];
  }
  // Force grouped fieldsets to not be collapsible (for vertical tabs).
  if (!empty($element['#group'])) {
    $variables['collapsible'] = FALSE;
    $variables['collapsed'] = FALSE;
  }
  $variables['id'] = '';
  if (isset($element['#id'])) {
    if ($variables['collapsible']) {
      $variables['id'] = $element['#id'];
    } else {
      $attributes['id'] = $element['#id'];
    }
  }
  $variables['content'] = $element['#children'];

  // Iterate over optional variables.
  $keys = array(
    'description',
    'prefix',
    'suffix',
    'title',
  );
  foreach ($keys as $key) {
    $variables[$key] = !empty($element["#$key"]) ? $element["#$key"] : FALSE;
  }
  $variables['attributes'] = $attributes;
}

/**
 * Process input elements.
 */
function _local_fixer_process_input(&$element, &$form_state) {
  // Only add the "form-control" class for specific element input types.
  $types = array(
    // Core.
    'password',
    'password_confirm',
    'select',
    'textarea',
    'textfield',
    // Elements module.
    'emailfield',
    'numberfield',
    'rangefield',
    'searchfield',
    'telfield',
    'urlfield',
  );
  if (!empty($element['#type']) && (in_array($element['#type'], $types) || ($element['#type'] === 'file' && empty($element['#managed_file'])))) {
    $element['#attributes']['class'][] = 'form-control-ing';
  }
  return $element;
}

/**
 * Overrides theme_form_element().
 */
function local_fixer_form_element(&$variables) {
  $element = &$variables['element'];
  $is_checkbox = FALSE;
  $is_radio = FALSE;

  // This function is invoked as theme wrapper, but the rendered form element
  // may not necessarily have been processed by form_builder().
  $element += array(
    '#title_display' => 'before',
  );

  // Add element #id for #type 'item'.
  if (isset($element['#markup']) && !empty($element['#id'])) {
    $attributes['id'] = $element['#id'];
  }

  // Check for errors and set correct error class.
  if (isset($element['#parents']) && form_get_error($element)) {
    $attributes['class'][] = 'error';
  }

  if (!empty($element['#type'])) {
    $attributes['class'][] = 'form-type-' . strtr($element['#type'], '_', '-');
  }
  if (!empty($element['#name'])) {
    $attributes['class'][] = 'form-item-' . strtr($element['#name'], array(
        ' ' => '-',
        '_' => '-',
        '[' => '-',
        ']' => '',
    ));
  }
  // Add a class for disabled elements to facilitate cross-browser styling.
  if (!empty($element['#attributes']['disabled'])) {
    $attributes['class'][] = 'form-disabled';
  }
  if (!empty($element['#autocomplete_path']) && drupal_valid_path($element['#autocomplete_path'])) {
    $attributes['class'][] = 'form-autocomplete';
  }
  $attributes['class'][] = 'form-item';

  // See http://getbootstrap.com/css/#forms-controls.
  if (isset($element['#type'])) {
    if ($element['#type'] == "radio") {
      $attributes['class'][] = 'gender-box';
      $is_radio = TRUE;
    } elseif ($element['#type'] == "checkbox") {
      $attributes['class'][] = 'gender-box';
      $is_checkbox = TRUE;
    } else {
      $attributes['class'][] = '';
    }
  }

  $description = FALSE;
  $tooltip = FALSE;
  // Convert some descriptions to tooltips.
  // @see bootstrap_tooltip_descriptions setting in _bootstrap_settings_form()
  if (!empty($element['#description'])) {
    $description = $element['#description'];
    if (theme_get_setting('bootstrap_tooltip_enabled') && theme_get_setting('bootstrap_tooltip_descriptions') && $description === strip_tags($description) && strlen($description) <= 200) {
      $tooltip = TRUE;
      $attributes['data-toggle'] = 'tooltip';
      $attributes['title'] = $description;
    }
  }

  $output = '<div' . drupal_attributes($attributes) . '>' . "\n";

  // If #title is not set, we don't display any label or required marker.
  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }

  $prefix = '';
  $suffix = '';
  if (isset($element['#field_prefix']) || isset($element['#field_suffix'])) {
    // Determine if "#input_group" was specified.
    if (!empty($element['#input_group'])) {
      //$prefix .= '<div class="input-group">';
      //$prefix .= isset($element['#field_prefix']) ? '<span class="input-group-addon">' . $element['#field_prefix'] . '</span>' : '';
      //$suffix .= isset($element['#field_suffix']) ? '<span class="input-group-addon">' . $element['#field_suffix'] . '</span>' : '';
      //$suffix .= '</div>';
    } else {
      $prefix .= isset($element['#field_prefix']) ? $element['#field_prefix'] : '';
      $suffix .= isset($element['#field_suffix']) ? $element['#field_suffix'] : '';
    }
  }

  switch ($element['#title_display']) {
    case 'before':
    case 'invisible':
      $output .= ' ' . theme('form_element_label', $variables);
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;

    case 'after':
      if ($is_radio || $is_checkbox) {
        $output .= ' ' . $prefix . $element['#children'] . $suffix;
      } else {
        $variables['#children'] = ' ' . $prefix . $element['#children'] . $suffix;
      }
      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      break;

    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;
  }

  if ($description && !$tooltip) {
    $output .= '<p class="help-block">' . $element['#description'] . "</p>\n";
  }

  $output .= "</div>\n";

  return $output;
}

/**
 * Overrides theme_container().
 */
function local_fixer_container($variables) {
  $element = $variables['element'];

  // Special handling for form elements.
  if (isset($element['#array_parents'])) {
    // Assign an html ID.
    if (!isset($element['#attributes']['id'])) {
      $element['#attributes']['id'] = $element['#id'];
    }
    // Add classes.
    $element['#attributes']['class'][] = 'form-wrapper';
    $element['#attributes']['class'][] = '';
  }

  return '<div' . drupal_attributes($element['#attributes']) . '>' . $element['#children'] . '</div>';
}

/**
 * Process variables for user-picture.tpl.php.
 *
 * The $variables array contains the following arguments:
 * - $account: A user, node or comment object with 'name', 'uid' and 'picture'
 *   fields.
 *
 * @see user-picture.tpl.php
 */
function local_fixer_preprocess_user_picture(&$variables) {
  $variables['user_picture'] = '';
  if (variable_get('user_pictures', 0)) {
    $account = $variables['account'];
    if (!empty($account->picture)) {
      // @TODO: Ideally this function would only be passed file objects, but
      // since there's a lot of legacy code that JOINs the {users} table to
      // {node} or {comments} and passes the results into this function if we
      // a numeric value in the picture field we'll assume it's a file id
      // and load it for them. Once we've got user_load_multiple() and
      // comment_load_multiple() functions the user module will be able to load
      // the picture files in mass during the object's load process.
      if (is_numeric($account->picture)) {
        $account->picture = file_load($account->picture);
      }
      if (!empty($account->picture->uri)) {
        $filepath = $account->picture->uri;
      }
    } elseif (variable_get('user_picture_default', '')) {
      $filepath = variable_get('user_picture_default', '');
    }
    if (isset($filepath)) {
      $alt = t("@user's picture", array('@user' => format_username($account)));
      // If the image does not have a valid Drupal scheme (for eg. HTTP),
      // don't load image styles.
      if (module_exists('image') && file_valid_uri($filepath) && $style = variable_get('user_picture_style', '')) {
        $variables['user_picture'] = theme('image_style', array('style_name' => $style, 'path' => $filepath, 'alt' => $alt, 'title' => $alt));
      } else {
        $variables['user_picture'] = theme('image', array('path' => $filepath, 'alt' => $alt, 'title' => $alt));
      }
      if (!empty($account->uid) && user_access('access user profiles')) {
        $attributes = array('attributes' => array('title' => t('View user profile.')), 'html' => TRUE);
        //$variables['user_picture'] = l($variables['user_picture'], "user/$account->uid", $attributes);
      }
    }
  }
}

function local_fixer_preprocess_field($variables) {
  
}

/**
 * Implements hook_theme().
 */
function local_fixer_theme($existing, $type, $theme, $path) {
  return array(
    'select_as_checkboxes' => array(
      'function' => 'local_fixer_select_as_checkboxes',
      'render element' => 'element',
    )
  );
}

/**
 * Themes a select element as a set of checkboxes.
 *
 * @see http://api.drupal.org/api/function/theme_select/7
 *
 * @param array $vars
 *   An array of arrays, the 'element' item holds the properties of the element.
 *
 * @return string
 *   HTML representing the form element.
 */
function local_fixer_select_as_checkboxes($vars) {

  $element = $vars['element'];

  if ($element['#name'] == 'field_reivew_interest_tid') {

    // The selected keys from #options.
    $selected_options = empty($element['#value']) ? $element['#default_value'] : $element['#value'];

    // Build a bunch of nested unordered lists to represent the hierarchy based
    // on the '-' prefix added by Views or optgroup structure.
    $output = '<div class="">
                        <div class="filter-form clearfix">
                          <div class="intrest-box" id="boxscroll">
                            <div id="contentscroll2">';
    $output.= '<ul class="bef-tree">';
    $curr_depth = -1;
    foreach ($element['#options'] as $option_value => $option_label) {

      // Check for Taxonomy-based filters.
      if (is_object($option_label)) {
        $slice = array_slice($option_label->option, 0, 1, TRUE);
        list($option_value, $option_label) = each($slice);
      }

      // Check for optgroups -- which is basically a two-level deep tree.
      if (is_array($option_label)) {
        // TODO:
      } else {
        // Build hierarchy based on prefixed '-' on the element label.
        if (t('- Any -') == $option_label) {
          $depth = -1;
        } else {
          preg_match('/^(-*).*$/', $option_label, $matches);
          $depth = strlen($matches[1]);

          $option_label = ltrim($option_label, '-');
        }
        //echo '<pre>';print_r($element['#options']);die;
        // Build either checkboxes or radio buttons, depending on Views' settings.
        $html = '';
        if (!empty($element['#multiple'])) {
          $html = bef_checkbox(
            $element, $option_value, $option_label, (array_search($option_value, $selected_options) !== FALSE)
          );
        } else {
          $element[$option_value]['#title'] = $option_label;
          $element[$option_value]['#children'] = theme('radio', array('element' => $element[$option_value]));
          $html .= theme('form_element', array('element' => $element[$option_value]));
        }
        if ($depth == 0 && $option_value == 0) {
          $output .= '<button type="button" class="btn accordian-btn collapsed" data-toggle="collapse" data-target="#demo' . $option_value . '">
                                            <span class="button-text">' . $option_label . '</span>
                                          </button>
                                          <div id="demo' . $option_value . '" class="collapse">
                                            <ul class="intrest-filter-list"><li><div class="filter-form clearfix">' . $html . '</div></li>';
        } else if ($depth == 0 && $option_value != 0) {
          $output .= '</ul></div><button type="button" class="btn accordian-btn collapsed" data-toggle="collapse" data-target="#demo' . $option_value . '">
                                            <span class="button-text">' . $option_label . '</span>
                                          </button>
                                          <div id="demo' . $option_value . '" class="collapse">
                                            <ul class="intrest-filter-list"><li><div class="filter-form clearfix">' . $html . '</div></li>';
        } else {
          $output .= '<li><div class="filter-form clearfix">' . $html . '</div></li>';
        }
      }
    } // foreach ($element['#options'] as $option_value => $option_label)
    // Close the opening <ul class="bef-tree"> tag.
    $output .= '</ul>';
    $output .= '</div>
                      </div>
                    </div>
                  </div>';

    // Add exposed filter description.
    $description = '';
    if (!empty($element['#bef_description'])) {
      $description = '<div class="description">' . $element['#bef_description'] . '</div>';
    }

    // Add the select all/none option, if needed.
    if (!empty($element['#bef_select_all_none'])) {
      if (empty($element['#attributes']['class'])) {
        $element['#attributes']['class'] = array();
      }
      $element['#attributes']['class'][] = 'bef-select-all-none';
    }
    // Add the select all/none nested option, if needed.
    if (!empty($element['#bef_select_all_none_nested'])) {
      if (empty($element['#attributes']['class'])) {
        $element['#attributes']['class'] = array();
      }
      $element['#attributes']['class'][] = 'bef-select-all-none-nested';
    }

    // Name and multiple attributes are not valid for <div>'s.
    if (isset($element['#attributes']['name'])) {
      unset($element['#attributes']['name']);
    }
    if (isset($element['#attributes']['multiple'])) {
      unset($element['#attributes']['multiple']);
    }

    return '<div' . drupal_attributes($element['#attributes']) . ">$description$output</div>";
  } else {

    $element = $vars['element'];
    if (!empty($element['#bef_nested'])) {
      if (empty($element['#attributes']['class'])) {
        $element['#attributes']['class'] = array();
      }
      $element['#attributes']['class'][] = 'form-checkboxes';
      return theme('select_as_tree', array('element' => $element));
    }

    // The selected keys from #options.
    $selected_options = empty($element['#value']) ? $element['#default_value'] : $element['#value'];
    if (!is_array($selected_options)) {
      $selected_options = array($selected_options);
    }

    // Grab exposed filter description.  We'll put it under the label where it
    // makes more sense.
    $description = '';
    if (!empty($element['#bef_description'])) {
      $description = '<div class="description">' . $element['#bef_description'] . '</div>';
    }

    $output = '<div class="bef-checkboxes">';
    foreach ($element['#options'] as $option => $elem) {
      if ('All' === $option) {
        // TODO: 'All' text is customizable in Views.
        // No need for an 'All' option -- either unchecking or checking all the
        // checkboxes is equivalent.
        continue;
      }

      // Check for Taxonomy-based filters.
      if (is_object($elem)) {
        $slice = array_slice($elem->option, 0, 1, TRUE);
        list($option, $elem) = each($slice);
      }

      // Check for optgroups.  Put subelements in the $element_set array and add
      // a group heading. Otherwise, just add the element to the set.
      $element_set = array();
      $is_optgroup = FALSE;
      if (is_array($elem)) {
        $output .= '<div class="bef-group">';
        $output .= '<div class="bef-group-heading">' . $option . '</div>';
        $output .= '<div class="bef-group-items">';
        $element_set = $elem;
        $is_optgroup = TRUE;
      } else {
        $element_set[$option] = $elem;
      }
      $element['#attributes']['class'][] = 'filter-form clearfix';
      foreach ($element_set as $key => $value) {
        $output .= bef_checkbox($element, $key, $value, array_search($key, $selected_options) !== FALSE);
      }

      if ($is_optgroup) {
        // Close group and item <div>s.
        $output .= '</div></div>';
      }
    }
    $output .= '</div>';

    // Fake theme_checkboxes() which we can't call because it calls
    // theme_form_element() for each option.
    $attributes['class'] = array('form-checkboxes', 'bef-select-as-checkboxes');
    if (!empty($element['#bef_select_all_none'])) {
      $attributes['class'][] = 'bef-select-all-none';
    }
    if (!empty($element['#bef_select_all_none_nested'])) {
      $attributes['class'][] = 'bef-select-all-none-nested';
    }
    if (!empty($element['#attributes']['class'])) {
      $attributes['class'] = array_merge($element['#attributes']['class'], $attributes['class']);
    }

    return '<div' . drupal_attributes($attributes) . ">$description$output</div>";
  }
}

/**
 * Overrides theme_textfield().
 */
function local_fixer_textfield($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'text';
  element_set_attributes($element, array(
    'id',
    'name',
    'value',
    'size',
    'maxlength',
  ));
  _form_set_class($element, array('form-text'));

  $output = '<input' . drupal_attributes($element['#attributes']) . ' />';

  $extra = '';
  if ($element['#autocomplete_path'] && drupal_valid_path($element['#autocomplete_path'])) {
    drupal_add_library('system', 'drupal.autocomplete');
    $element['#attributes']['class'][] = 'form-autocomplete';

    $attributes = array();
    $attributes['type'] = 'hidden';
    $attributes['id'] = $element['#attributes']['id'] . '-autocomplete';
    $attributes['value'] = url($element['#autocomplete_path'], array('absolute' => TRUE));
    $attributes['disabled'] = 'disabled';
    $attributes['class'][] = 'autocomplete';
    $output = '<div>' . $output . '</div>';
    $extra = '<input' . drupal_attributes($attributes) . ' />';
  }

  return $output . $extra;
}

/**
 * function to overwrite links. removes the reply link per node type
 *
 * @param $links
 * @param $attributes
 * @return unknown_type
 */
function local_fixer_links($links, $attributes = array('class' => 'links')) {

// check if the comment reply link exists
  if (isset($links['links']['comment-delete'])) {
    unset($links['links']['comment-delete']);
  }
  if (isset($links['links']['comment-edit'])) {
    unset($links['links']['comment-edit']);
  }
  if (isset($links['links']['comment-reply'])) {
    $links['links']['comment-reply']['title'] = t('+ REPLY');
    $links['links']['comment-reply']['attributes']['class'][2] = t('reply-link');
  }
  //pa($links);
  return theme_links($links, $attributes);
}

function local_fixer_preprocess_comment(&$variables) {
  //pa($variables['elements']['#comment']);
  $variables['created'] = $variables['elements']['#node']->created;
  $variables['comment_date'] = date('h:ia', $variables['elements']['#comment']->created) . ' on ' . date('dS F, Y', $variables['elements']['#comment']->created);
  $comment_uid = $variables['elements']['#comment']->uid;

  $user_info = user_load($comment_uid);
  $user_image = file_create_url($user_info->picture->uri);

  $types = profile2_get_types();
  $user_info = profile2_load_by_user($comment_uid, $type_name = 'main');
  $variables['user_image'] = $user_image;
  $variables['user_first_name'] = $user_info->field_name['und']['0']['value'];
  $country = "";
  if (isset($user_info->field_country['und']['0']['value'])) {
    $country = $user_info->field_country['und']['0']['value'];
  }
  $variables['location'] = t('From ') . $user_info->field_city['und']['0']['value'] . ' ,' . $country;
}