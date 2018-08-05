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
      $tax_type_options[$id] = $tax->label();
    } 
    return $tax_type_options;
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

  /**
   * {@inheritdoc}
   */
  public static function EntityConfigOptions($config_type) {
    $types = \Drupal::entityTypeManager()->getStorage($config_type)->loadMultiple();
    foreach($types as $id => $type) {
      $options[$id] = $type->label();
    } 
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public static function EntityOptions($entity_type) {
    $entities = entity_load_multiple($entity_type);
    foreach($entities as $id => $entity) {
      $options[$id] = $entity->getName();
    } 
    return $options;
  }

}
