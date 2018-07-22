<?php

namespace Drupal\restaurant_orders\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Zone entity.
 *
 * @ConfigEntityType(
 *   id = "restaurant_zone",
 *   label = @Translation("Zone"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\restaurant_orders\ZoneListBuilder",
 *     "form" = {
 *       "add" = "Drupal\restaurant_orders\Form\ZoneForm",
 *       "edit" = "Drupal\restaurant_orders\Form\ZoneForm",
 *       "delete" = "Drupal\restaurant_orders\Form\ZoneDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\restaurant_orders\ZoneHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "restaurant_zone",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/restaurant_zone/{restaurant_zone}",
 *     "add-form" = "/admin/structure/restaurant_zone/add",
 *     "edit-form" = "/admin/structure/restaurant_zone/{restaurant_zone}/edit",
 *     "delete-form" = "/admin/structure/restaurant_zone/{restaurant_zone}/delete",
 *     "collection" = "/admin/structure/restaurant_zone"
 *   }
 * )
 */
class Zone extends ConfigEntityBase implements ZoneInterface {

  /**
   * The Zone ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Zone label.
   *
   * @var string
   */
  protected $label;

}
