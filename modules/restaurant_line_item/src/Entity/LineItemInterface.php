<?php

namespace Drupal\restaurant_line_item\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Line item entities.
 *
 * @ingroup restaurant_line_item
 */
interface LineItemInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Line item name.
   *
   * @return string
   *   Name of the Line item.
   */
  public function getName();

  /**
   * Sets the Line item name.
   *
   * @param string $name
   *   The Line item name.
   *
   * @return \Drupal\restaurant_line_item\Entity\LineItemInterface
   *   The called Line item entity.
   */
  public function setName($name);

  /**
   * Gets the Line item product.
   *
   * @return \Drupal\restaurant_line_item\Entity\LineItemInterface
   *   Product of the Line item.
   */
  public function getProduct();

  /**
   * Gets the Line item product name.
   *
   * @return string
   *   Name of the Line item product.
   */
  public function getProductName();

  /**
   * Gets the Line item product price.
   *
   * @return float
   *   Price of the Line item product.
   */
  public function getProductPrice();

  /**
   * Get the price of the line item.
   *
   * @return float
   *   The price of the line item.
   */
  public function getPrice();

  /**
   * Sets the Line item price.
   *
   * @param string $price
   *   The Line item price.
   *
   * @return \Drupal\restaurant_line_item\Entity\LineItemInterface
   *   The called Line item entity.
   */
  public function setPrice($price);

  /**
   * Get the quantity of the line item.
   *
   * @return integer
   *   The quantity of the line item.
   */
  public function getQuantity();

  /**
   * Get the amount of the line item.
   *
   * @return float
   *   The calculated amount of the line item.
   */
  public function getAmount();

  /**
   * Gets the Line item creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Line item.
   */
  public function getCreatedTime();

  /**
   * Sets the Line item creation timestamp.
   *
   * @param int $timestamp
   *   The Line item creation timestamp.
   *
   * @return \Drupal\restaurant_line_item\Entity\LineItemInterface
   *   The called Line item entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Line item published status indicator.
   *
   * Unpublished Line item are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Line item is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Line item.
   *
   * @param bool $published
   *   TRUE to set this Line item to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\restaurant_line_item\Entity\LineItemInterface
   *   The called Line item entity.
   */
  public function setPublished($published);

}
