<?php

namespace Drupal\restaurant_line_item\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Line item entities.
 */
class LineItemViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
