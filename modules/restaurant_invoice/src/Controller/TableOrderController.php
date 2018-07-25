<?php
namespace Drupal\restaurant_invoice\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class TableOrderController.
 *
 * @package Drupal\restaurant_invoice\Controller
 */
class TableOrderController extends ControllerBase {
  /**
   * Tables.
   *
   * @return array
   *   Return Tables.
   */
  public function tables() {
    return [
      '#theme' => 'tables',
      '#tables' => \Drupal::entityTypeManager()->getStorage('restaurant_table')->loadMultiple(),
      '#zones' => [],
    ];
  }
}