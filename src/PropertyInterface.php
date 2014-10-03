<?php

/**
 * @file
 * Provides Drupal\themekey\PropertyInterface
 */

namespace Drupal\themekey;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for ThemeKey property plugins.
 */
interface PropertyInterface extends PluginInspectionInterface {

  /**
   * Return the name of the ThemeKey property.
   *
   * @return string
   */
  public function getName();

  /**
   * Return the Description of the ThemeKey property.
   *
   * @return float
   */
  public function getDescription();

}
