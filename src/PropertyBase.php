<?php

/**
 * @file
 * Provides Drupal\themekey\PropertyBase.
 */

namespace Drupal\themekey;

use Drupal\themekey\Plugin\SingletonPluginBase;

abstract class PropertyBase extends SingletonPluginBase implements PropertyInterface {

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->pluginDefinition['name'];
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->pluginDefinition['description'];
  }
}

