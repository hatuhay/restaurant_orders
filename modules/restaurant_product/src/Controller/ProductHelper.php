<?php

namespace Drupal\restaurant_product\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Component\Utility\Tags;
use Drupal\Component\Utility\Unicode;

/**
 * Defines a route controller for entity autocomplete form elements.
 */
class ProductHelper extends ControllerBase {

  /**
   * Handler for autocomplete request.
   */
  public static function ListProducts() {
    $matches = [];

    // Get an array of matching entities.
    $query = \Drupal::entityQuery('restaurant_product')
      ->condition('status', 1);
    $eids = $query->execute();
    $entities = \Drupal::entityTypeManager()->getStorage('restaurant_product')->loadMultiple($eids);
    
    foreach ($entities as $entity_id => $entity) {
      $label = $entity->getName();
      $price = $entity->getPrice();
      $category = $entity->getCategory();
      $key = $entity_id;
      $matches[$key] = ['value' => $key, 'label' => $label, 'price' => $price, 'category' => $category->label(), 'weight' => $category->getWeight()];
    }
 
    return $matches;
  }

  /**
   * {@inheritdoc}
   */
  public function getProductOptions() {
    $options = array();
    $products = self::ListProducts();
    usort($products, "_cmp");
    usort($products, "_intcmp");
    foreach ($products as $product) {
      $options[$product['category']][$product['value']] = t('@product_title (@product_price)', array(
        '@product_title' => $product['label'],
        '@product_price' => $product['price'],
      ));
    }

    return $options;
  }

}