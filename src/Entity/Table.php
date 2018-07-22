<?php

namespace Drupal\restaurant_orders\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Table entity.
 *
 * @ConfigEntityType(
 *   id = "restaurant_table",
 *   label = @Translation("Table"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\restaurant_orders\TableListBuilder",
 *     "form" = {
 *       "add" = "Drupal\restaurant_orders\Form\TableForm",
 *       "edit" = "Drupal\restaurant_orders\Form\TableForm",
 *       "delete" = "Drupal\restaurant_orders\Form\TableDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\restaurant_orders\TableHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "restaurant_table",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/restaurant_table/{restaurant_table}",
 *     "add-form" = "/admin/structure/restaurant_table/add",
 *     "edit-form" = "/admin/structure/restaurant_table/{restaurant_table}/edit",
 *     "delete-form" = "/admin/structure/restaurant_table/{restaurant_table}/delete",
 *     "collection" = "/admin/structure/restaurant_table"
 *   }
 * )
 */
class Table extends ConfigEntityBase implements TableInterface {

  /**
   * The Table ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Table label.
   *
   * @var string
   */
  protected $label;

  /**
   * The Tax type.
   *
   * @var string
   */
  protected $table_zone;

}
