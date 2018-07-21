<?php

namespace Drupal\restaurant_invoice\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Payment status entity.
 *
 * @ConfigEntityType(
 *   id = "payment_status",
 *   label = @Translation("Payment status"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\restaurant_invoice\PaymentStatusListBuilder",
 *     "form" = {
 *       "add" = "Drupal\restaurant_invoice\Form\PaymentStatusForm",
 *       "edit" = "Drupal\restaurant_invoice\Form\PaymentStatusForm",
 *       "delete" = "Drupal\restaurant_invoice\Form\PaymentStatusDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\restaurant_invoice\PaymentStatusHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "payment_status",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/payment_status/{payment_status}",
 *     "add-form" = "/admin/structure/payment_status/add",
 *     "edit-form" = "/admin/structure/payment_status/{payment_status}/edit",
 *     "delete-form" = "/admin/structure/payment_status/{payment_status}/delete",
 *     "collection" = "/admin/structure/payment_status"
 *   }
 * )
 */
class PaymentStatus extends ConfigEntityBase implements PaymentStatusInterface {

  /**
   * The Payment status ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Payment status label.
   *
   * @var string
   */
  protected $label;

}
