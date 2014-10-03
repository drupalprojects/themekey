<?php

/**
 * @file
 * Provides Drupal\themekey\OperatorInterface
 */

namespace Drupal\themekey;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for ThemeKey operator plugins.
 */
interface OperatorInterface extends PluginInspectionInterface {

  /**
   * Return the name of the ThemeKey operator.
   *
   * @return string
   */
  public function getName();

  /**
   * Return the Description of the ThemeKey operator.
   *
   * @return float
   */
  public function getDescription();

}
