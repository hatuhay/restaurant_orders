<?php

namespace Drupal\restaurant_orders\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Tax entities.
 */
interface TaxInterface extends ConfigEntityInterface {

  /**
   * Gets the tax percent.
   *
   * @return float
   *   The tax percent.
   */
  public function getPercent();

}
