<?php

/**
 * @file
 * Provides Drupal\themekey\OperatorBase.
 */

namespace Drupal\themekey;

use Drupal\Component\Plugin\PluginBase;

abstract class OperatorBase extends PluginBase implements OperatorInterface {

  public function getName() {
    return $this->pluginDefinition['name'];
  }

  public function getDescription() {
    return $this->pluginDefinition['description'];
  }

}

