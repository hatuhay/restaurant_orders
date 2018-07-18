<?php

namespace Drupal\restaurant_customer\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Customer type entity.
 *
 * @ConfigEntityType(
 *   id = "restaurant_customer_type",
 *   label = @Translation("Customer type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\restaurant_customer\CustomerTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\restaurant_customer\Form\CustomerTypeForm",
 *       "edit" = "Drupal\restaurant_customer\Form\CustomerTypeForm",
 *       "delete" = "Drupal\restaurant_customer\Form\CustomerTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\restaurant_customer\CustomerTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "restaurant_customer_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "restaurant_customer",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/restaurant_customer_type/{restaurant_customer_type}",
 *     "add-form" = "/admin/structure/restaurant_customer_type/add",
 *     "edit-form" = "/admin/structure/restaurant_customer_type/{restaurant_customer_type}/edit",
 *     "delete-form" = "/admin/structure/restaurant_customer_type/{restaurant_customer_type}/delete",
 *     "collection" = "/admin/structure/restaurant_customer_type"
 *   }
 * )
 */
class CustomerType extends ConfigEntityBundleBase implements CustomerTypeInterface {

  /**
   * The Customer type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Customer type label.
   *
   * @var string
   */
  protected $label;

}
