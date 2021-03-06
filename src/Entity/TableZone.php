<?php

namespace Drupal\restaurant_orders\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Entity\EntityStorageInterface;

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

  /**
   * The weight of this role in administrative listings.
   *
   * @var int
   */
  protected $weight;

  /**
   * {@inheritdoc}
   */
  public function getWeight() {
    return $this->get('weight');
  }

  /**
   * {@inheritdoc}
   */
  public function setWeight($weight) {
    $this->set('weight', $weight);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function postLoad(EntityStorageInterface $storage, array &$entities) {
    parent::postLoad($storage, $entities);
    // Sort the queried payment by their weight.
    // See \Drupal\Core\Config\Entity\ConfigEntityBase::sort().
    uasort($entities, 'static::sort');
  }

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);

    if (!isset($this->weight) && ($zones = $storage->loadMultiple())) {
      // Set a role weight to make this new role last.
      $max = array_reduce($zones, function ($max, $zone) {
        return $max > $zone->weight ? $max : $zone->weight;
      });
      $this->weight = $max + 1;
    }

  }
}
