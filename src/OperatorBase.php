<?php

/**
 * @file
 * Provides Drupal\themekey\OperatorBase.
 */

namespace Drupal\themekey;

use Drupal\themekey\Plugin\SingletonPluginBase;

abstract class OperatorBase extends SingletonPluginBase implements OperatorInterface {

  public function getName() {
    return $this->pluginDefinition['name'];
  }

  public function getDescription() {
    return $this->pluginDefinition['description'];
  }

}

