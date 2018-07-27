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
   *   Return Theme.
   */
  public function tables() {
    return [
      '#theme' => 'tables',
      '#tables' => self::getTables(),
      '#zones' => \Drupal::entityTypeManager()->getStorage('restaurant_table_zone')->loadMultiple(),
    ];
  }

  /**
   * Tables.
   *
   * @return array
   *   Return Tables formated.
   */
  protected function getTables() {
    $tables = \Drupal::entityTypeManager()->getStorage('restaurant_table')->loadMultiple();
    foreach($tables as $table) {
      $result[$table->id()] = [ 
        'id' => $table->id(),
        'label' => $table->label(),
        'zone' => $table->tableZone(),
      ];
    }
    return $result;
  }
}