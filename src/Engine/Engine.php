<?php
/**
 * Created by PhpStorm.
 * User: mkalkbrenner
 * Date: 03.10.14
 * Time: 13:32
 */

namespace Drupal\themekey\Engine;

use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\themekey\EngineInterface;
use MyProject\Proxies\__CG__\stdClass;

class Engine implements EngineInterface {

  /**
   * The system theme config object.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * @var
   */
  protected $propertyManager;

  /**
   * @var
   */
  protected $operatorManager;

  /**
   * Constructs a DefaultNegotiator object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * Gets the ThemeKey Property manager.
   *
   * @return \Drupal\Component\Plugin\PluginManagerInterface
   *   The ThemeKey Property manager.
   */
  protected function getPropertyManager() {
    if (!$this->propertyManager) {
      $this->propertyManager = \Drupal::service('plugin.manager.themekey.property');
    }

    return $this->propertyManager;
  }

  /**
   * Sets the ThemeKey Property manager to use.
   *
   * @param \Drupal\Component\Plugin\PluginManagerInterface
   *   The ThemeKey Property manager.
   *
   * @return $this
   */
  public function setPropertyManager(PluginManagerInterface $propertyManager) {
    $this->propertyManager = $propertyManager;

    return $this;
  }

  /**
   * Gets the ThemeKey Operator manager.
   *
   * @return \Drupal\Component\Plugin\PluginManagerInterface
   *   The ThemeKey Operator manager.
   */
  protected function getOperatorManager() {
    if (!$this->operatorManager) {
      $this->operatorManager = \Drupal::service('plugin.manager.themekey.operator');
    }

    return $this->operatorManager;
  }

  /**
   * Sets the ThemeKey Property manager to use.
   *
   * @param \Drupal\Component\Plugin\PluginManagerInterface
   *   The ThemeKey Property manager.
   *
   * @return $this
   */
  public function setOperatorManager(PluginManagerInterface $operatorManager) {
    $this->operatorManager = $operatorManager;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function determineTheme(RouteMatchInterface $route_match) {
//    $properties = $this->getPropertyManager()->getDefinitions();
//    $operators = $this->getOperatorManager()->getDefinitions();
//
//    drupal_set_message(print_r($properties, TRUE));
//    drupal_set_message(print_r($operators, TRUE));

    $rule = new \stdClass();
    $rule->property = 'system:query_param';
    $rule->operator = '=';
    $rule->value = 'theme=bartik';
    $rule->theme = 'bartik';

    return $this->matchCondition($rule) ? $rule->theme : NULL;
  }

  /**
   * Detects if a ThemeKey rule matches to the current
   * page request.
   *
   * @param object $condition
   *   ThemeKey rule as object:
   *   - property
   *   - operator
   *   - value
   *
   * @return bool
   */
  public function matchCondition(/* TODO condition interface */ $condition) {
    // Default operator is 'equal'
    if (empty($condition->operator)) {
      $condition->operator = '=';
    }

    $operator = $this->getOperatorManager()
      ->createInstance($condition->operator);

    $property = $this->getPropertyManager()
      ->createInstance($condition->property);

    #drupal_set_message(print_r($property->getValues(), TRUE));

    foreach ($property->getValues() as $value) {
      #drupal_set_message($value);
      if ($operator->evaluate($condition->value, $value)) {
        return TRUE;
      }
    }

    return FALSE;
  }
}