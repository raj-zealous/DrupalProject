<?php
/**
 *
 *
 * @file
 */

/**
 * List the available configurations.
 *
 * @return string
 */
function stepwise_configuration_list() {
  $rows = array();
  $configurations = stepwise_get_configurations();

  foreach ($configurations as $stepwise) {
    $rows[] = array(
      'link' => stepwise_link($stepwise),
      'edit' => l('edit', 'admin/config/workflow/stepwise/' . $stepwise->name . '/edit'),
    );
  }

  return theme('table', array('header' => array(t('Name'), t('Edit')), 'rows' => $rows));
}


/**
 * This form provide the multistep form for the configurations.
 *
 * @param $module
 * @param $id
 *
 * @return bool
 */
function stepwise_page_form($module, $id, $js = NULL, $step = NULL) {
  if (!module_exists($module)) {
    return array();
  }

  // At the first step we should load all of the steps.
  $configurations = array();
  if (empty($form_state['configurations_info'])) {
    $configurations = stepwise_get_configurations();
    if (!isset($configurations[$id])) {
      return array();
    }
  }

  $form_info = array(
    'id' => 'stepwise', //form id
    'path' => "stepwise/" . $module . "/" . $id . "/display/" . ($js ? 'ajax' : 'nojs') . '/%step/step',
    'show trail' => FALSE, //show the breadcrumb / path trail for the forms
    'show back' => FALSE, //show the back button
    'show cancel' => FALSE, //show the cancel button
    'show return' => FALSE, //show the update and return button
    'finish callback' => 'stepwise_page_form_submit', //callback when finish button is called
    'next text' => t('Next'),
    'auto cache' => TRUE,
  );

  foreach ($configurations[$id]->steps as $conf) {
    $menu_information = menu_get_item($conf['url']);
    $form_info['order'][] = $conf['form'];
    // Every drupal_get_form first argument is the form id. We pass every other arguments.
    array_shift($menu_information['page_arguments']);
    $step_info = array(
      // Store the page arguments.
      'arguments' => $conf['arguments'],
      // The ctools functions aren't calling the form functions directly.
      'form id' => 'stepwise_multistepform_wrapper_calback',
      // The actual step form id.
      'current form id' => $conf['form'],
      // This file containing the form implementation.
      'include' => $menu_information['include_file'],
    );

    $form_info['forms'][] = $step_info;
  }

  // Init the step variable.
  if (empty($step)) {
    $step = 0;
  }

  // Send this all off to our form. This is like drupal_get_form only wizardy.
  ctools_include('wizard');
  ctools_include('object-cache');
  $form = ctools_wizard_multistep_form($form_info, $step, $form_state);
  $output = drupal_render($form);
  return $output;
}

/**
 * This is a wrapper function for managing formbuilding during the steps.
 * This wrapper function is add because the system setting forms are usually has not any parameters,
 * that casuing the form wrapper callback function results will lost. The ctools wizard api is heavily using
 * the forms wrapper callback functions.
 *
 * @param $form
 * @param $form_state
 */
function stepwise_multistepform_wrapper_calback($form, &$form_state) {
  $step = $form_state['step'];
  $current_form_id = $form_state['form_info']['forms'][$step]['current form id'];
  // Set the form arguments.
  $form_state['build_info']['args'] = $form_state['form_info']['forms'][$step]['arguments'];
  // Build the given form.
  $form += drupal_retrieve_form($current_form_id, $form_state);
  // Hide every submit buttons.
  stepwise_remove_submit_buttons($form);
  // Let's allow any other module to modify the form array.
  drupal_alter('stepwise_step_form', $form);
  return $form;
}

/**
 * The configuration finish callback.
 *
 * @param $form
 * @param $form_state
 */
function stepwise_page_form_submit(&$form_state) {
  $form_state['redirect'] = array('admin/config/workflow/stepwise');
}

/**
 * This form collect the necessary information for creating stepwise configuration.
 *
 * @param $form
 * @param $form_state
 *
 * @return mixed
 */
function stepwise_add_form($form, &$form_state) {
  $form['name'] = array(
    '#type' => 'textfield',
    '#title' => t('Name'),
    '#description' => t('Use only lowercase alphanumeric characters, underscores (_), and hyphens (-).'),
    '#required' => TRUE,
    '#element_validate' => array('stepwise_configuration_name_validate'),
  );

  $form['description'] = array(
    '#type' => 'textfield',
    '#title' => t('Description'),
    '#description' => t('The configuration description.'),
    '#required' => TRUE,
  );

  $form['group'] = array(
    '#type' => 'textfield',
    '#title' => t('Group'),
    '#description' => t('The group of the configuration.'),
  );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Submit'),
  );

  return $form;
}

/**
 * Element validate function to ensure that the configuration name is in the correct format.
 *
 * @param $element
 * @param $form_state
 */
function stepwise_configuration_name_validate($element, $form_state) {
  $modules = array();
    // Get current list of modules.
  $files = system_rebuild_module_data();
  foreach ($files as $filename => $file) {
    if (!isset($file->info['hidden'])) {
      $modules[] = $filename;
    }
  }

  // Check for duplicates.
  if (in_array($element['#value'], $modules)) {
    form_set_error($element['#name'], t('The %name module name is already taken. Please choose an other.',
      array('%name' => $element['#value'])));
  }

  // Check for illegal characters in the configuration name.
  if (preg_match('/[^0-9a-z_\-]/', $element['#value'])) {
    form_set_error($element['#name'], t('Please only use lowercase alphanumeric characters, underscores (_), and hyphens (-) for style names.'));
  }
}

/**
 * Set up the basic inforamtions.
 *
 * @param $form
 * @param $form_state
 */
function stepwise_add_form_submit($form, &$form_state) {
  $_SESSION['active_stepwise'] = $form_state['values']['name'];
  $stepwise = new stdClass();
  $stepwise->name = $form_state['values']['name'];
  $stepwise->group = $form_state['values']['group'];
  $stepwise->description = $form_state['values']['description'];
  $stepwise->steps = array();

  stepwise_object_cache_set($form_state['values']['name'], $stepwise);

  $form_state['redirect'] = array("admin/config/workflow/stepwise/$stepwise->name/edit");
}

/**
 * The Stepwise configuration builder edit form.
 *
 * @param $form
 * @param $form_state
 * @param $id
 *
 * @return array
 */
function stepwise_edit_form($form, &$form_state, $stepwise) {
  if (empty($stepwise)) {
    drupal_goto('admin/config/workflow/stepwise');
    return $form;
  }
  // Set the active stepwise to the currently edited.
  $_SESSION['active_stepwise'] = $stepwise->name;

  // List the configuration steps.
  if (!empty($stepwise->steps)) {
    $form['elements']['#tree'] = TRUE;
    // Fill up an array with operations on steps.
    $operations = array();
    foreach ($stepwise->steps as $key => $step) {
      $operations[$key]['remove'] = array(
        'title' => t('remove'),
        'href' => "admin/config/workflow/stepwise/$stepwise->name/step/$key/remove",
        'query' => drupal_get_destination(),
      );
    }

    // Let the user to expand the operations array with implementind the hook_stepwise_step_operations_alter.
    drupal_alter('stepwise_step_operations', $operations);

    foreach ($stepwise->steps as $key => $step) {
      $form['elements'][$key]['formid'] = array(
        '#type' => 'hidden',
        '#value' => $step['form'],
      );
      $form['elements'][$key]['url'] = array(
        '#type' => 'hidden',
        '#value' => $step['url'],
      );
      $form['elements'][$key]['name'] = array(
        '#markup' => $step['form'],
      );
      $form['elements'][$key]['operations'] = array(
        '#markup' => theme('links__ctools_dropbutton', array('links' => $operations[$key],
          'attributes' => array('class' => array('links', 'inline'))))
      );
      $form['elements'][$key]['weight'] = array(
        '#type' => 'weight',
        '#title_display' => 'invisible',
        '#title' => t('Weight'),
        '#default_value' => $key,
        '#attributes' => array('class' => array('configuration-workflow-form-sequence')),
      );
    }
  }

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Export'),
  );

  $form['cancel'] = array(
    '#type' => 'submit',
    '#value' => t('Cancel'),
    '#submit' => array('stepwise_cancel_cache_submit'),
  );

  return $form;
}

/**
 * Export the active configuration.
 *
 * @param $form
 * @param $form_state
 */
function stepwise_edit_form_submit($form, &$form_state) {
  if (empty($form_state['values']['elements'])) {
    return;
  }

  // Remove the last step to avoid the duplications.
  if (isset($_GET['form']) && isset($_GET['destination'])) {
    array_pop($form_state['values']['elements']);
  }

  $stepwise = stepwise_object_cache_get($_SESSION['active_stepwise']);

  ctools_include('object-cache');
  ctools_object_cache_clear('stepwise', $_SESSION['active_stepwise']);
  ctools_object_cache_clear('stepwise', 'active_page_form_variables');
  unset($_SESSION['active_stepwise']);

  $stepwiseModuleExport = new StepwiseModuleExport($stepwise);
  $stepwiseModuleExport->export();
}

/**
 * Drop every changes.
 *
 * @param $form
 * @param $form_state
 */
function stepwise_cancel_cache_submit($form, &$form_state) {
  ctools_object_cache_clear('stepwise', $_SESSION['active_stepwise']);
  unset($_SESSION['active_stepwise']);
  unset($_GET['destination']);
  $form_state['redirect'] = array('admin/config/workflow/stepwise');
}

/**
 *
 *
 * @param $form
 * @param $form_state
 * @return mixed
 */
function stepwise_settings_form($form, &$form_state, $stepwise) {
  $form_state['stepwise'] = $stepwise;
  $files = system_rebuild_module_data();
  // Remove hidden modules from display list.
  $modules = array();
  foreach ($files as $filename => $file) {
    if (empty($file->info['hidden'])) {
      $modules[$filename] = $filename;
    }
  }

  uasort($modules, 'stepwise_sort_modules_by_info_name');

  $form['promote'] = array(
    '#type' => 'checkbox',
    '#title' => t('Promote to admin/modules page'),
    '#description' => t(''),
    '#default_value' => ($stepwise->promote) ? TRUE : FALSE,
    '#attributes' => array('id' => 'promote'),
  );

  $form['modules'] = array(
    '#type' => 'select',
    '#options' => $modules,
    '#title' => t('Modules'),
    '#default_value' => $stepwise->promote,
    '#states' => array(
      'invisible' => array(
        ':input[id="promote"]' => array('checked' => FALSE),
      ),
    ),
  );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save'),
  );

  return $form;
}

/**
 *
 *
 * @param $form
 * @param $form_state
 */
function stepwise_settings_form_submit($form, &$form_state) {
  $stepwise = $form_state['stepwise'];
  $stepwise->promote = ($form_state['values']['promote']) ? $form_state['values']['modules'] : FALSE;
  ctools_include('object-cache');
  stepwise_object_cache_set($stepwise->name, $stepwise);
  $form_state['redirect'] = array('admin/config/workflow/stepwise');
}

function stepwise_sort_modules_by_info_name($a, $b) {
  return strcasecmp($a, $b);
}

