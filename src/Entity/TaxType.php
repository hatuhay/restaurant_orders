<?php

namespace Drupal\restaurant_orders\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Tax type entity.
 *
 * @ConfigEntityType(
 *   id = "restaurant_tax_type",
 *   label = @Translation("Tax type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\restaurant_orders\TaxTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\restaurant_orders\Form\TaxTypeForm",
 *       "edit" = "Drupal\restaurant_orders\Form\TaxTypeForm",
 *       "delete" = "Drupal\restaurant_orders\Form\TaxTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\restaurant_orders\TaxTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "restaurant_tax_type",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/restaurant_tax_type/{restaurant_tax_type}",
 *     "add-form" = "/admin/structure/restaurant_tax_type/add",
 *     "edit-form" = "/admin/structure/restaurant_tax_type/{restaurant_tax_type}/edit",
 *     "delete-form" = "/admin/structure/restaurant_tax_type/{restaurant_tax_type}/delete",
 *     "collection" = "/admin/structure/restaurant_tax_type"
 *   }
 * )
 */
class TaxType extends ConfigEntityBase implements TaxTypeInterface {

  /**
   * The Tax type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Tax type label.
   *
   * @var string
   */
  protected $label;

  /**
   * The Tax type description.
   *
   * @var string
   */
  protected $description;

}
