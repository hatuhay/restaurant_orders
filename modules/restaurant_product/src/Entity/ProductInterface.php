<?php

namespace Drupal\restaurant_product\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Product entities.
 *
 * @ingroup restaurant_product
 */
interface ProductInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Product name.
   *
   * @return string
   *   Name of the Product.
   */
  public function getName();

  /**
   * Sets the Product name.
   *
   * @param string $name
   *   The Product name.
   *
   * @return \Drupal\restaurant_product\Entity\ProductInterface
   *   The called Product entity.
   */
  public function setName($name);

  /**
   * Gets the Product price.
   *
   * @return float
   *   Price of the Product.
   */
  public function getPrice();

  /**
   * Gets the Product creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Product.
   */
  public function getCreatedTime();

  /**
   * Sets the Product creation timestamp.
   *
   * @param int $timestamp
   *   The Product creation timestamp.
   *
   * @return \Drupal\restaurant_product\Entity\ProductInterface
   *   The called Product entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Product published status indicator.
   *
   * Unpublished Product are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Product is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Product.
   *
   * @param bool $published
   *   TRUE to set this Product to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\restaurant_product\Entity\ProductInterface
   *   The called Product entity.
   */
  public function setPublished($published);

}
