<?php
/**
 * Created by PhpStorm.
 * User: mkalkbrenner
 * Date: 03.10.14
 * Time: 11:24
 */

namespace Drupal\themekey\Theme;
use Drupal\Core\Theme\ThemeNegotiatorInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

class ThemeKeyNegotiator implements ThemeNegotiatorInterface {
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
  public function applies(RouteMatchInterface $route_match) {
    return TRUE;

    // TODO migrate complete function themekey_is_active() to applies()

    // Don't change theme when ...
    if (
      (in_array('system', variable_get('themekey_compat_modules_enabled', array())) || !(variable_get('admin_theme', '0') && path_is_admin($_GET['q']))) // ... admin area and admin theme set
      && strpos($_GET['q'], 'admin/structure/block/demo') !== 0 // ... block demo runs
      && strpos($_SERVER['SCRIPT_FILENAME'], 'cron.php') === FALSE // ... cron is executed by cron.php
      && strpos($_SERVER['SCRIPT_FILENAME'], 'drush.php') === FALSE // ... cron is executed by drush
      && (!defined('MAINTENANCE_MODE') || (MAINTENANCE_MODE != 'install' && MAINTENANCE_MODE != 'update')) // ... drupal installation or update runs
    ) {
      require_once DRUPAL_ROOT . '/' . drupal_get_path('module', 'themekey') . '/themekey_base.inc';
      $paths = $paths = array_merge_recursive(themekey_invoke_modules('themekey_disabled_paths'), module_invoke_all('themekey_disabled_paths'));
      foreach ($paths as $path) {
        if (strpos($_GET['q'], $path) === 0) {
          return FALSE;
        }
      }
      return TRUE;
    }
    return FALSE;
  }
  /**
   * {@inheritdoc}
   */
  public function determineActiveTheme(RouteMatchInterface $route_match) {
    // Here you return the actual theme name.
    return isset($_GET['theme']) ? $_GET['theme'] : NULL;
  }
}