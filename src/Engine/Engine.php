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
use Drupal\themekey\EngineInterface;
use Drupal\themekey\PropertyManagerTrait;
use Drupal\themekey\OperatorManagerTrait;
use Drupal\themekey\Entity\ThemeKeyRule;
use Drupal\themekey\ThemeKeyRuleInterface;

class Engine implements EngineInterface {

  use PropertyManagerTrait;
  use OperatorManagerTrait;

  /**
   * The system theme config object.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

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
   * {@inheritdoc}
   */
  public function determineTheme(RouteMatchInterface $route_match) {
    $rules = ThemeKeyRule::loadMultiple();

    foreach ($rules as $rule) {
      if ($this->matchCondition($rule)) {
        // TODO cascade (recursive)
        return $rule->theme;
      }
    }

    return NULL;
  }

  /**
   * Detects if a ThemeKey rule matches to the current
   * page request.
   *
   * @param object $rule
   *   ThemeKey rule as object:
   *   - property
   *   - operator
   *   - value
   *
   * @return bool
   */
  public function matchCondition(ThemeKeyRuleInterface $rule) {
    $operator = $this->getOperatorManager()
      ->createInstance($rule->operator());

    $property = $this->getPropertyManager()
      ->createInstance($rule->property());

    #drupal_set_message(print_r($property->getValues(), TRUE));

    $values = $property->getValues();
    $key = $rule->key();

    if (!is_null($key)) {
      if (isset($values[$key])) {
        return $operator->evaluate($values[$key], $rule->value());
      }
    }
    else {
      foreach ($values as $value) {
        if ($operator->evaluate($value, $rule->value())) {
          return TRUE;
        }
      }
    }

    return FALSE;
  }
}
