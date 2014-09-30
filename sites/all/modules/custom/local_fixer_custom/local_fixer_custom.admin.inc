<?php

/**
 * @file
 * Functions that are only called on the admin pages.
 */

/**
 * Module settings form.
 */
function custom_admin_settings() {
  // General settings.
  $form['general'] = array(
    '#type' => 'fieldset',
    '#title' => t('Custom Module Settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  return system_settings_form($form);
}

/*
 * Custom function to fetch the front page content type nid and title
 */

function _fetch_nodes($type = 'front_page') {

  $query = db_select('node', 'n')
    ->fields('n', array('nid', 'title'))
    ->condition('n.type', $type);

  $result = $query->execute();

  while ($record = $result->fetchAssoc()) {
    $nids[$record['nid']] = $record['title'] . " (nid - " . $record['nid'] . ")";
  }
  return $nids;
}