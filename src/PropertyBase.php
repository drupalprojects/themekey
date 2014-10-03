<?php

/**
 * @file
 * Provides Drupal\themekey\PropertyBase.
 */

namespace Drupal\themekey;

use Drupal\Component\Plugin\PluginBase;

abstract class PropertyBase extends PluginBase implements PropertyInterface {

  public function getName() {
    return $this->pluginDefinition['name'];
  }

  public function getDescription() {
    return $this->pluginDefinition['description'];
  }

}

