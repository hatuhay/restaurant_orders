<?php

namespace Drupal\restaurant_invoice\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Payment entities.
 */
interface PaymentInterface extends ConfigEntityInterface {

  /**
   * Returns the weight.
   *
   * @return int
   *   The weight of this role.
   */
  public function getWeight();

  /**
   * Sets the weight to the given value.
   *
   * @param int $weight
   *   The desired weight.
   *
   * @return $this
   */
  public function setWeight($weight);

  /**
   * Returns the default status.
   *
   * @return string
   *   The weight of this role.
   */
  public function getStatus();

  /**
   * Returns the default status label.
   *
   * @return string
   *   The weight of this role.
   */
  public function getStatusLabel();

}
