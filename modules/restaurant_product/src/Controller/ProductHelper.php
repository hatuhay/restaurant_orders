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
class RestaurantHelper extends ControllerBase {

  /**
   * Handler for autocomplete request.
   */
  public function PopupProducts() {
    $matches = [];

    // Get an array of matching entities.
    $query = \Drupal::entityQuery('restaurant_product')
      ->condition('status', 1)
    $eids = $query->execute();
    $entities = \Drupal::entityTypeManager()->getStorage('restaurant_product')->loadMultiple($eids);
    
    foreach ($entities as $entity_id => $entity) {
      $label = $entity->getName();
      $price = $entity->getPrice();
      $key = $entity_id;
      $label = $label . ' (' . $entity_id . ') [' . $price . ']';
      $matches[$key] = ['value' => $key, 'label' => $label];
    }
 
    return $matches;
  }

}