<?php
/**
 *
 * @file
 *  This file contains every stepwise theme function.
 */

/**
 * Stepwise configuration builder form theme function.
 *
 * @param $variables
 *
 * @return null|string
 */
function theme_stepwise_edit_form(&$variables) {
  $output = NULL;
  $rows = array();
  $form = $variables['form'];
  drupal_add_tabledrag('stepwise-form-table', 'order', 'sibling',
    'configuration-workflow-form-sequence');

  if (!empty($form['elements'])) {
    foreach(element_children($form['elements']) as $element) {
      $row = array(
        drupal_render($form['elements'][$element]['name']),
        drupal_render($form['elements'][$element]['operations']),
        drupal_render($form['elements'][$element]['weight']),
      );
      $rows[] = array('data' => $row, 'class' => array('draggable'));
    }
  }

  $output = theme('table', array('header' => array(t('FORM ID'), t('OPERATIONS'), t('WEIGHT')),
    'rows' => $rows, 'attributes' => array('id' => 'stepwise-form-table')));
  $output .= drupal_render_children($form);

  return $output;
}

/**
 * Stepwise configuration builder dialog theme function.
 *
 * @param $variables
 * @return null
 */
function theme_stepwise_dialog(&$variables) {
  $output = NULL;
  $element = $variables['element'];

  $output .= '<div id="stepwise-dialog-label">Stepwise</div>';
  $output .= '<div id="stepwise-dialog-introduction">' . t('You are currently editing the !stepwise configuration workflow.',
    array('!stepwise' => l($element['conf']['name'], 'admin/config/workflow/stepwise/' . $element['conf']['name'] . '/edit'))) . '</div>';

  $output .= '<div id="stepwise-dialog-links">';
  foreach ($element['conf']['links'] as $link) {
    $output .= $link;
  }
  $output .= '</div>';

  return $output;
}


/**
 *
 *
 * @param $variables
 * @return string
 */
function _stepwise_system_modules_fieldset($variables) {
  $form = $variables['form'];

  // Individual table headers.
  $rows = array();
  // Iterate through all the modules, which are
  // children of this fieldset.
  foreach (element_children($form) as $key) {
    // Stick it into $module for easier accessing.
    $module = $form[$key];
    $row = array();
    unset($module['enable']['#title']);
    $row[] = array('class' => array('checkbox'), 'data' => drupal_render($module['enable']));
    $label = '<label';
    if (isset($module['enable']['#id'])) {
      $label .= ' for="' . $module['enable']['#id'] . '"';
    }
    $row[] = $label . '><strong>' . drupal_render($module['name']) . '</strong></label>';
    $row[] = drupal_render($module['version']);
    // Add the description, along with any modules it requires.
    $description = drupal_render($module['description']);
    if ($module['#requires']) {
      $description .= '<div class="admin-requirements">' . t('Requires: !module-list', array('!module-list' => implode(', ', $module['#requires']))) . '</div>';
    }
    if ($module['#required_by']) {
      $description .= '<div class="admin-requirements">' . t('Required by: !module-list', array('!module-list' => implode(', ', $module['#required_by']))) . '</div>';
    }
    $row[] = array('data' => $description, 'class' => array('description'));
    // Display links (such as help or permissions) in their own columns.
    foreach (array('help', 'permissions', 'configure', 'stepwise') as $key) {
      $row[] = array('data' => drupal_render($module['links'][$key]), 'class' => array($key));
    }
    $rows[] = $row;
  }

  return theme('table', array('header' => $form['#header'], 'rows' => $rows));
}

/**
 *
 *
 * @param $variables
 */
function _stepwise_module_filter_modules_table($variables) {
  $form = $variables['form'];

  // Individual table headers.
  $rows = array();
  // Iterate through all the modules, which are
  // Children of this fieldset.
  foreach (element_children($form) as $key) {
    // Stick it into $module for easier accessing.
    $module = $form[$key];
    $row = array();
    unset($module['enable']['#title']);
    $row[] = array('class' => array('checkbox'), 'data' => drupal_render($module['enable']));
    $label = '<label';
    if (isset($module['enable']['#id'])) {
      $label .= ' for="' . $module['enable']['#id'] . '"';
    }
    $row[] = $label . '><strong>' . drupal_render($module['name']) . '</strong></label>';
    $row[] = drupal_render($module['version']);
    // Add the description, along with any modules it requires.
    $description = drupal_render($module['description']);
    if ($module['#requires']) {
      $description .= '<div class="admin-requirements">' . t('Requires: !module-list', array('!module-list' => implode(', ', $module['#requires']))) . '</div>';
    }
    if ($module['#required_by']) {
      $description .= '<div class="admin-requirements">' . t('Required by: !module-list', array('!module-list' => implode(', ', $module['#required_by']))) . '</div>';
    }
    $row[] = array('data' => $description, 'class' => array('description'));
    // Display links (such as help or permissions) in their own columns.
    foreach (array('help', 'permissions', 'configure', 'stepwise') as $key) {
      $row[] = array('data' => drupal_render($module['links'][$key]), 'class' => array($key));
    }

    $id = module_filter_get_id($module['#package']);
    $rows[] = array(
      'data' => $row,
      'class' => array($id . '-tab-content'),
    );
  }

  return theme('table', array(
    'header' => $form['#header'],
    'rows' => $rows,
    'attributes' => array('class' => array('package')),
    )
  );
}
