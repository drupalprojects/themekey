<?php

/**
 * @file
 * Contains \Drupal\themekey\Annotation\Operator.
 */

namespace Drupal\themekey\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a ThemeKey Operator annotation object.
 *
 * Plugin Namespace: Plugin\themekey\operator
 *
 * @see \Drupal\themekey\Plugin\OperatorManager
 * @see plugin_api
 *
 * @Annotation
 */
class Operator extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

}
