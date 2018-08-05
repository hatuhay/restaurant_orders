<?php

namespace Drupal\restaurant_line_item\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Line item entity.
 *
 * @ingroup restaurant_line_item
 *
 * @ContentEntityType(
 *   id = "restaurant_line_item",
 *   label = @Translation("Line item"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\restaurant_line_item\LineItemListBuilder",
 *     "views_data" = "Drupal\restaurant_line_item\Entity\LineItemViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\restaurant_line_item\Form\LineItemForm",
 *       "add" = "Drupal\restaurant_line_item\Form\LineItemForm",
 *       "edit" = "Drupal\restaurant_line_item\Form\LineItemForm",
 *       "delete" = "Drupal\restaurant_line_item\Form\LineItemDeleteForm",
 *     },
 *     "access" = "Drupal\restaurant_line_item\LineItemAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\restaurant_line_item\LineItemHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "restaurant_line_item",
 *   admin_permission = "administer line item entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/restaurant_line_item/{restaurant_line_item}",
 *     "add-form" = "/admin/structure/restaurant_line_item/add",
 *     "edit-form" = "/admin/structure/restaurant_line_item/{restaurant_line_item}/edit",
 *     "delete-form" = "/admin/structure/restaurant_line_item/{restaurant_line_item}/delete",
 *     "collection" = "/admin/restaurant/restaurant_line_item",
 *   },
 *   field_ui_base_route = "restaurant_line_item.settings"
 * )
 */
class LineItem extends ContentEntityBase implements LineItemInterface {

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
  public function getProduct() {
    return $this->get('product')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getProductName() {
    return $this->getProduct()->getName();
  }

  /**
   * {@inheritdoc}
   */
  public function getProductPrice() {
    return $this->getProduct()->getPrice();
  }

  /**
   * {@inheritdoc}
   */
  public function getAmount() {
    $price = $this->getPrice();
    $quantity = $this->getQuantity();
    return bcmul($price, $quantity, 2);
  }

  /**
   * {@inheritdoc}
   */
  public function setPrice($price) {
    $this->set('price', $price);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getPrice() {
    $price = $this->get('price')->getValue();
    return $price[0]['value'];
  }

  /**
   * {@inheritdoc}
   */
  public function getQuantity() {
    $qty = $this->get('quantity')->getValue();
    return $qty[0]['value'];
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
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);

    // The file itself might not exist or be available right now.
    $product = $this
      ->getProductName();
    $qty = $this
      ->getQuantity();
    $price = $this
      ->getProductPrice();

    $this
      ->setName(t('@product - Quantity: @qty', ['@product' => $product, '@qty' => $qty]));
    $this
      ->setPrice($price);
  }

  /**
   * {@inheritdoc}
   */

   public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
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
        'hidden' => TRUE,
        'disabled' => TRUE,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        'hidden' => TRUE,
        'disabled' => TRUE,
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['product'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Product'))
      ->setRequired(TRUE)
      ->setRevisionable(FALSE)
      ->setSetting('target_type', 'restaurant_product')
      ->setSetting('handler', 'default')
      ->setTranslatable(FALSE)
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
//        '#type' => 'textfield',
//        '#autocomplete_route_name' => 'restaurant_product.autocomplete',
//        '#autocomplete_route_parameters' => array('field_name' => 'name', 'count' => 10),
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
        'disabled' => TRUE,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['quantity'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Quantity'))
      ->setRequired(TRUE)
      ->setDefaultValue(0)
      ->setSettings([
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['price'] = BaseFieldDefinition::create('decimal')
      ->setLabel(t('Price'))
      ->setDefaultValue(0)
      ->setSettings([
        'precision' => 19,
        'scale' => 2,
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

    $fields['overwrite'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Price is overwrited'))
      ->setDefaultValue(FALSE)
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['notes'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Note'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDefaultValue(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
