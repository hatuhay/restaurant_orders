<?php

namespace Drupal\restaurant_orders\Controller;

/**
 * @file
 * Contains \Drupal\restaurant_orders\Controller\RestaurantHelper.
 */
use Drupal\Core\Controller\ControllerBase;

/**
 * Transaction Manager.
 */
class RestaurantHelper extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public static function TaxTypeOptions() {
    $tax_types = \Drupal::entityTypeManager()->getStorage('restaurant_tax_type')->loadMultiple();
    foreach($tax_types as $id => $tax) {
      $tax_options[$id] = $tax->label();
    } 
    return $tax_options;
  }

  /**
   * {@inheritdoc}
   */
  public static function TaxOptions() {
    $taxes = \Drupal::entityTypeManager()->getStorage('restaurant_tax')->loadMultiple();
    foreach($taxes as $id => $tax) {
      $tax_options[$id] = $tax->label();
    } 
    return $tax_options;
  }

}
