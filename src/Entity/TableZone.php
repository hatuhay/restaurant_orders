<?php

namespace Drupal\restaurant_orders\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Table zone entity.
 *
 * @ConfigEntityType(
 *   id = "restaurant_table_zone",
 *   label = @Translation("Table zone"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\restaurant_orders\TableZoneListBuilder",
 *     "form" = {
 *       "add" = "Drupal\restaurant_orders\Form\TableZoneForm",
 *       "edit" = "Drupal\restaurant_orders\Form\TableZoneForm",
 *       "delete" = "Drupal\restaurant_orders\Form\TableZoneDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\restaurant_orders\TableZoneHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "restaurant_table_zone",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/restaurant_table_zone/{restaurant_table_zone}",
 *     "add-form" = "/admin/structure/restaurant_table_zone/add",
 *     "edit-form" = "/admin/structure/restaurant_table_zone/{restaurant_table_zone}/edit",
 *     "delete-form" = "/admin/structure/restaurant_table_zone/{restaurant_table_zone}/delete",
 *     "collection" = "/admin/structure/restaurant_table_zone"
 *   }
 * )
 */
class TableZone extends ConfigEntityBase implements TableZoneInterface {

  /**
   * The Table zone ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Table zone label.
   *
   * @var string
   */
  protected $label;

}
