<?php

/**
 * @file
 * Integrates Workbench Moderation module's paths into ThemeKey.
 *
 * @author Markus Kalkbrenner | bio.logis GmbH
 *   @see http://drupal.org/user/124705
 */


/**
 * Implements hook_themekey_paths().
 */
function themekey_workbench_moderation_themekey_paths() {
  $paths = array();

  $paths[] = array('path' => 'node/#node:nid/draft');

  return $paths;
}
