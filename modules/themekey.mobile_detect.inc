<?php

/**
 * @file
 * Provides mobile_detect rules as ThemeKey properties.
 *
 * @author Markus Kalkbrenner | bio.logis GmbH
 *   @see http://drupal.org/user/124705
 */


/**
 * Implements hook_themekey_properties().
 *
 * Provides additional properties for the ThemeKey module:
 * - mobile_detect:is...
 *
 * @return
 *   array of themekey properties and mapping functions
 */
function themekey_mobile_detect_themekey_properties() {
  // Attributes of properties
  $attributes = array();
  // Mapping functions
  $maps = array();

  if ($mobile_detect = mobile_detect_get_object()) {
    $rules = array_merge(
      array_keys($mobile_detect->getRules()),
      array(
        'Mobile',
        'Tablet',
      )
    );
    foreach ($rules as $rule) {
      $property = 'mobile_detect:is' . $rule;

      $attributes[$property] = array(
        'description' => t("Mobile Detect: @rule - 'true' or 'false'", array('@rule' => $rule)),
        'validator' => 'themekey_validator_string_boolean',
        'page cache' => THEMEKEY_PAGECACHE_UNSUPPORTED,
      );

      $maps[] = array(
        'src' => 'system:dummy',
        'dst' => $property,
        'callback' => 'themekey_mobile_detect_dummy2rule',
        'args' => array(
          'method' => 'is' . $rule,
        ),
      );
    }
  }

  return array('attributes' => $attributes, 'maps' => $maps);
}


/**
* ThemeKey mapping function to set a
* ThemeKey property's value (destination)
 * with the aid of another ThemeKey property (source).
 *
 * src: system:dummy
 * dst: mobile_detect:is...
 *
 * @param $nid
 *   a node id
 * @param $args
 *   array, keys required:
 *    - 'method'
 *
 * @return
 *   string 'true' or 'false'
 *   or NULL if mobile_detect is not available
 */
function themekey_mobile_detect_dummy2rule($nid, $args) {
  if ($mobile_detect = mobile_detect_get_object()) {
    return ($mobile_detect->{$args['method']}()) ? 'true' : 'false';
  }

  return NULL;
}
