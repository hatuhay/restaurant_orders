<?php

namespace Drupal\restaurant_product\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Entity\EntityStorageInterface;

/**
 * Defines the Product category entity.
 *
 * @ConfigEntityType(
 *   id = "restaurant_product_category",
 *   label = @Translation("Product category"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\restaurant_product\ProductCategoryListBuilder",
 *     "form" = {
 *       "add" = "Drupal\restaurant_product\Form\ProductCategoryForm",
 *       "edit" = "Drupal\restaurant_product\Form\ProductCategoryForm",
 *       "delete" = "Drupal\restaurant_product\Form\ProductCategoryDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\restaurant_product\ProductCategoryHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "restaurant_product_category",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/product/restaurant_product_category/{restaurant_product_category}",
 *     "add-form" = "/admin/structure/restaurant_product_category/add",
 *     "edit-form" = "/admin/structure/restaurant_product_category/{restaurant_product_category}/edit",
 *     "delete-form" = "/admin/structure/restaurant_product_category/{restaurant_product_category}/delete",
 *     "collection" = "/admin/structure/restaurant_product_category"
 *   }
 * )
 */
class ProductCategory extends ConfigEntityBase implements ProductCategoryInterface {

  /**
   * The Product category ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Product category label.
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

    if (!isset($this->weight) && ($categories = $storage->loadMultiple())) {
      // Set a role weight to make this new role last.
      $max = array_reduce($categories, function ($max, $category) {
        return $max > $category->weight ? $max : $category->weight;
      });
      $this->weight = $max + 1;
    }

  }
}