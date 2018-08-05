<?php

namespace Drupal\restaurant_invoice\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Invoice entities.
 *
 * @ingroup restaurant_invoice
 */
interface InvoiceInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Invoice name.
   *
   * @return string
   *   Name of the Invoice.
   */
  public function getName();

  /**
   * Sets the Invoice name.
   *
   * @param string $name
   *   The Invoice name.
   *
   * @return \Drupal\restaurant_invoice\Entity\InvoiceInterface
   *   The called Invoice entity.
   */
  public function setName($name);

  /**
   * Gets the Invoice creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Invoice.
   */
  public function getCreatedTime();

  /**
   * Sets the Invoice creation timestamp.
   *
   * @param int $timestamp
   *   The Invoice creation timestamp.
   *
   * @return \Drupal\restaurant_invoice\Entity\InvoiceInterface
   *   The called Invoice entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Invoice published status indicator.
   *
   * Unpublished Invoice are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Invoice is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Invoice.
   *
   * @param bool $published
   *   TRUE to set this Invoice to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\restaurant_invoice\Entity\InvoiceInterface
   *   The called Invoice entity.
   */
  public function setPublished($published);

  /**
   * Get the currency entity of the Invoice.
   *
   * @return \Drupal\restaurant_invoice\Entity\InvoiceInterface
   *   The curency entity.
   */
  public function getCurrency();

  /**
   * Sets the currency of a Invoice.
   *
   * @param string $code
   *   The currency code.
   *
   * @return \Drupal\restaurant_invoice\Entity\InvoiceInterface
   *   The called Invoice entity.
   */
  public function setCurrencyCode($code);

  /**
   * Gets the currency for the Invoice.
   *
   * @return string
   *   The curency code.
   */
  public function getCurrencyCode();

  /**
   * Get the line_items of a Invoice.
   *
   * @return \Drupal\restaurant_invoice\Entity\InvoiceInterface
   *   The line items.
   */
  public function getLineItems();

  /**
   * Sets the currency of a Invoice.
   *
   * @param string $name
   *   The name of the line item.
   *
   * @return \Drupal\restaurant_invoice\Entity\InvoiceInterface
   *   The line item entity.
   */
  public function getLineItem($name);

  /**
   * Sets the currency of a Invoice.
   *
   * @return integer
   *   The amount Invoice entity.
   */
  public function getAmount();

  /**
   * Calculate amount of a Invoice.
   *
   * @return float
   *   The aount.
   */
  public function calculateAmount();

}
