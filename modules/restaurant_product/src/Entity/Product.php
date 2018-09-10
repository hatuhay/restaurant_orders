<?php

namespace Drupal\restaurant_product\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Product entity.
 *
 * @ingroup restaurant_product
 *
 * @ContentEntityType(
 *   id = "restaurant_product",
 *   label = @Translation("Product"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\restaurant_product\ProductListBuilder",
 *     "views_data" = "Drupal\restaurant_product\Entity\ProductViewsData",
 *     "translation" = "Drupal\restaurant_product\ProductTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\restaurant_product\Form\ProductForm",
 *       "add" = "Drupal\restaurant_product\Form\ProductForm",
 *       "edit" = "Drupal\restaurant_product\Form\ProductForm",
 *       "delete" = "Drupal\restaurant_product\Form\ProductDeleteForm",
 *     },
 *     "access" = "Drupal\restaurant_product\ProductAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\restaurant_product\ProductHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "restaurant_product",
 *   data_table = "restaurant_product_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer product entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/product/{restaurant_product}",
 *     "add-form" = "/admin/structure/restaurant/product/add",
 *     "edit-form" = "/admin/structure/restaurant/product/{restaurant_product}/edit",
 *     "delete-form" = "/admin/structure/restaurant/product/{restaurant_product}/delete",
 *     "collection" = "/admin/content/restaurant_product",
 *   },
 *   field_ui_base_route = "restaurant_product.settings"
 * )
 */
class Product extends ContentEntityBase implements ProductInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getPrice() {
    $price = $this->get('amount')->getValue();
    return $price[0]['value'];
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCategoryId() {
    return $this->get('category')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setCategoryId($cid) {
    $this->set('category', $cid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCategory() {
    return $this->get('category')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Product entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Product entity.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['currency'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Currency'))
      ->setSetting('target_type', 'currency')
      ->setSetting('handler', 'default')
      ->setDefaultValueCallback('Drupal\restaurant_orders\Controller\CurrencyHelper::getDefaultCurrency')
      ->setReadOnly(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'currency_sign',
        'weight' => -3,
        'settings' => [
          'link' => FALSE,
        ],
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['amount'] = BaseFieldDefinition::create('decimal')
      ->setLabel(t('Price'))
      ->setRequired(TRUE)
      ->setDefaultValue(0)
      ->setSettings([
        'precision' => 19,
        'scale' => 6,
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'currency_amount',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['category'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Product Category'))
      ->setSetting('target_type', 'restaurant_product_category')
      ->setSetting('handler', 'default')
      ->setReadOnly(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'weight' => -3,
        'settings' => [
          'link' => FALSE,
        ],
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['zone'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Restaurant Zone'))
      ->setSetting('target_type', 'restaurant_zone')
      ->setSetting('handler', 'default')
      ->setReadOnly(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'weight' => -3,
        'settings' => [
          'link' => FALSE,
        ],
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Product is published.'))
      ->setDefaultValue(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -3,
      ]);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
