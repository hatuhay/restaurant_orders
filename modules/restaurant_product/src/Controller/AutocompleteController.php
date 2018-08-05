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
class AutocompleteController extends ControllerBase {

  /**
   * Handler for autocomplete request.
   */
  public function handleAutocomplete(Request $request, $field_name, $count) {
    $matches = [];

    // Get the typed string from the URL, if it exists.
    if ($input = $request->query->get('q')) {
      $typed_string = Tags::explode($input);
      $string = Unicode::strtolower(array_pop($typed_string));

      // Get an array of matching entities.
      $query = \Drupal::entityQuery('restaurant_product')
        ->condition($field_name, $string, 'CONTAINS')
        ->condition('status', 1)
        ->range(0, $count);
      $eids = $query->execute();
      $entities = \Drupal::entityTypeManager()->getStorage('restaurant_product')->loadMultiple($eids);
      
      foreach ($entities as $entity_id => $entity) {
        $label = $entity->getName();
        $price = $entity->getPrice();
        $key = $label . ' (' . $entity_id . ') [' . $price . ']';
        // Strip things like starting/trailing white spaces, line breaks and tags.
        $key = preg_replace('/\s\s+/', ' ', str_replace("\n", '', trim(Html::decodeEntities(strip_tags($key)))));
        // Names containing commas or quotes must be wrapped in quotes.
        $key = Tags::encode($key);
        $label = $label . ' (' . $entity_id . ') [' . $price . ']';
        $matches[] = ['value' => $key, 'label' => $label];
      }
    }

    return new JsonResponse($matches);
  }

}