<?php

/**
 * @file
 * Contains \Drupal\themekey\Annotation\Property.
 */

namespace Drupal\themekey\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a ThemeKey Property annotation object.
 *
 * Plugin Namespace: Plugin\themekey\property
 *
 * @see \Drupal\themekey\Plugin\PropertyManager
 * @see plugin_api
 *
 * @Annotation
 */
class Property extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The price of one scoop of the flavor in dollars.
   *
   * @var string
   */
  public $group;

  /**
   * The name of the property.
   *
   * @var string
   */
  public $name;

}
