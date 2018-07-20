<?php

namespace Drupal\restaurant_invoice\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Invoice type entity.
 *
 * @ConfigEntityType(
 *   id = "invoice_type",
 *   label = @Translation("Invoice type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\restaurant_invoice\InvoiceTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\restaurant_invoice\Form\InvoiceTypeForm",
 *       "edit" = "Drupal\restaurant_invoice\Form\InvoiceTypeForm",
 *       "delete" = "Drupal\restaurant_invoice\Form\InvoiceTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\restaurant_invoice\InvoiceTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "invoice_type",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/invoice_type/{invoice_type}",
 *     "add-form" = "/admin/structure/invoice_type/add",
 *     "edit-form" = "/admin/structure/invoice_type/{invoice_type}/edit",
 *     "delete-form" = "/admin/structure/invoice_type/{invoice_type}/delete",
 *     "collection" = "/admin/structure/invoice_type"
 *   }
 * )
 */
class InvoiceType extends ConfigEntityBase implements InvoiceTypeInterface {

  /**
   * The Invoice type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Invoice type label.
   *
   * @var string
   */
  protected $label;

}
