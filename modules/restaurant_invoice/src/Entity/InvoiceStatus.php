<?php

namespace Drupal\restaurant_invoice\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Invoice status entity.
 *
 * @ConfigEntityType(
 *   id = "invoice_status",
 *   label = @Translation("Invoice status"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\restaurant_invoice\InvoiceStatusListBuilder",
 *     "form" = {
 *       "add" = "Drupal\restaurant_invoice\Form\InvoiceStatusForm",
 *       "edit" = "Drupal\restaurant_invoice\Form\InvoiceStatusForm",
 *       "delete" = "Drupal\restaurant_invoice\Form\InvoiceStatusDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\restaurant_invoice\InvoiceStatusHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "invoice_status",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/invoice_status/{invoice_status}",
 *     "add-form" = "/admin/structure/invoice_status/add",
 *     "edit-form" = "/admin/structure/invoice_status/{invoice_status}/edit",
 *     "delete-form" = "/admin/structure/invoice_status/{invoice_status}/delete",
 *     "collection" = "/admin/structure/invoice_status"
 *   }
 * )
 */
class InvoiceStatus extends ConfigEntityBase implements InvoiceStatusInterface {

  /**
   * The Invoice status ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Invoice status label.
   *
   * @var string
   */
  protected $label;

}
