<?php

/**
 * @file
 * Contains all form manipulations required by ThemeKey Redirect.
 *
 * @author Markus Kalkbrenner | bio.logis GmbH
 *   @see http://drupal.org/user/124705
 */

require_once DRUPAL_ROOT . '/' . drupal_get_path('module', 'themekey_redirect') . '/themekey_redirect_build.inc';
require_once DRUPAL_ROOT . '/' . drupal_get_path('module', 'themekey') . '/themekey_admin.inc';


/**
 * Form builder for the rule chain.
 *
 * The form will not be validated. All changes will be saved immediately.
 * Validation will happen when the form displays the stored configuration.
 * Otherwise all the drag'n'drop stuff will not work.
 *
 * @see themekey_form_alter()
 * @see themekey_rule_chain_form_submit()
 * @see themekey_rule_chain_form_set_error()
 *
 * @ingroup forms
 */
function themekey_redirect_rule_chain_form($form, &$form_state) {
  $form = themekey_abstract_rule_chain_form($form, $form_state, array(
    'load_rules_callback' => 'themekey_redirect_load_rules',
    'themes' => themekey_redirect_options(),
    'rule_delete_path' => 'admin/config/user-interface/themekey/redirects/delete/',
  ));

  $items = themekey_redirect_load_rules();

  if (!empty($form['old_items'])) {
    foreach ($form['old_items'] as $id => &$old_item) {
      $old_item['theme']['#type'] = 'textfield';
      unset($old_item['theme']['#options']);
      $old_item['append_path'] = array(
        '#type' => 'checkbox',
        '#title' => t('append path'),
        '#default_value' => isset($items[$id]['append_path']) ? $items[$id]['append_path'] : TRUE,
      );
    }
  }
  $form['new_item']['theme']['#type'] = 'textfield';
  $form['new_item']['theme']['#default_value'] = 'http://';
  unset($form['new_item']['theme']['#options']);
  $form['new_item']['append_path'] = array(
    '#type' => 'checkbox',
    '#title' => t('append path'),
    '#default_value' => TRUE,
  );

  return $form;
}

/**
 * Validation of
 * @see themekey_rule_chain_form()
 */
function themekey_redirect_rule_chain_form_validate(&$form, $form_state) {
  themekey_abstract_rule_chain_form_validate($form, $form_state, array(
    'check_enabled_callback' => 'themekey_redirect_check_url',
    'not_enabled_message' => t('Not a valid URL'),
  ));
}

/**
 * Form submission handler for themekey_rule_chain_form().
 *
 * @see themekey_rule_chain_form()
 */
function themekey_redirect_rule_chain_form_submit($form, &$form_state) {
  themekey_abstract_rule_chain_form_submit($form, $form_state, array(
    'rule_set_callback' => 'themekey_redirect_rule_set',
  ));
}

function themekey_redirect_check_url($url) {
  return preg_match('@http(|s)://.+@', $url);
}

/**
 * Menu callback -- ask for confirmation of ThemeKey rule deletion
 */
function themekey_redirect_admin_delete_rule_confirm($form, &$form_state, $arg, $themekey_property_id) {
  $form['themekey_property_id'] = array(
    '#type' => 'value',
    '#value' => $themekey_property_id,
  );

  $title = themekey_redirect_format_rule_as_string($themekey_property_id);

  return confirm_form($form,
    t('Are you sure you want to delete the ThemeKey rule, %title?', array('%title' => $title)),
    'admin/config/user-interface/themekey/redirects',
    t('This action cannot be undone.'),
    t('Delete'),
    t('Cancel')
  );
}


/**
 * Execute ThemeKey rule deletion
 */
function themekey_redirect_admin_delete_rule_confirm_submit($form, &$form_state) {
  if ($form_state['values']['confirm']) {
    themekey_redirect_rule_del($form_state['values']['themekey_property_id']);
  }

  $form_state['redirect'] = 'admin/config/user-interface/themekey/redirects';
}

/**
 * Themes themekey_redirect_rule_chain_form() and adds drag'n'drop features.
 *
 * @ingroup themeable
 */
function theme_themekey_redirect_rule_chain_form($variables) {
  return theme_themekey_abstract_rule_chain_form($variables, array(
    'header' => array(
      t('Redirecting Rule Chain'),
      t('Target'),
      t('Enabled'),
      t('Operation'),
      t('Parent'),
      t('Weight'),
      t('Page<br />Cache'),
    )
  ));
}