<?php

namespace Drupal\restaurant_invoice\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Payment entity.
 *
 * @ConfigEntityType(
 *   id = "payment",
 *   label = @Translation("Payment"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\restaurant_invoice\PaymentListBuilder",
 *     "form" = {
 *       "add" = "Drupal\restaurant_invoice\Form\PaymentForm",
 *       "edit" = "Drupal\restaurant_invoice\Form\PaymentForm",
 *       "delete" = "Drupal\restaurant_invoice\Form\PaymentDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\restaurant_invoice\PaymentHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "payment",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/payment/{payment}",
 *     "add-form" = "/admin/structure/payment/add",
 *     "edit-form" = "/admin/structure/payment/{payment}/edit",
 *     "delete-form" = "/admin/structure/payment/{payment}/delete",
 *     "collection" = "/admin/structure/payment"
 *   }
 * )
 */
class Payment extends ConfigEntityBase implements PaymentInterface {

  /**
   * The Payment ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Payment label.
   *
   * @var string
   */
  protected $label;

  /**
   * The Payment Default Status.
   *
   * @var string
   */
  protected $default_status;

}
