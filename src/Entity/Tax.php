<?php

namespace Drupal\restaurant_orders\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Tax entity.
 *
 * @ConfigEntityType(
 *   id = "restaurant_tax",
 *   label = @Translation("Tax"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\restaurant_orders\TaxListBuilder",
 *     "form" = {
 *       "add" = "Drupal\restaurant_orders\Form\TaxForm",
 *       "edit" = "Drupal\restaurant_orders\Form\TaxForm",
 *       "delete" = "Drupal\restaurant_orders\Form\TaxDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\restaurant_orders\TaxHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "restaurant_tax",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/restaurant_tax/{restaurant_tax}",
 *     "add-form" = "/admin/structure/restaurant_tax/add",
 *     "edit-form" = "/admin/structure/restaurant_tax/{restaurant_tax}/edit",
 *     "delete-form" = "/admin/structure/restaurant_tax/{restaurant_tax}/delete",
 *     "collection" = "/admin/structure/restaurant_tax"
 *   }
 * )
 */
class Tax extends ConfigEntityBase implements TaxInterface {

  /**
   * The Tax ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Tax label.
   *
   * @var string
   */
  protected $label;

}
