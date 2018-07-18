<?php

/**
 * @file
 * Contains restaurant_invoice.page.inc.
 *
 * Page callback for Invoice entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Invoice templates.
 *
 * Default template: restaurant_invoice.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_restaurant_invoice(array &$variables) {
  // Fetch Invoice Entity Object.
  $restaurant_invoice = $variables['elements']['#restaurant_invoice'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
