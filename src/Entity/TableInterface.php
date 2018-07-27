<?php

namespace Drupal\restaurant_orders\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Table entities.
 */
interface TableInterface extends ConfigEntityInterface {

/**
   * Returns the value of the table zone.
   *
   */
  public function tableZone();

/**
   * Returns the value of the shape.
   *
   */
  public function shape();

/**
   * Sets the value of the shape.
   *
   */
  public function setShape($value);

/**
   * Returns an array with left and top coordinates.
   *
   */
  public function position();

/**
   * Sets de coordinates position of the shape.
   *
   */
  public function setPosition($left, $right);

}
