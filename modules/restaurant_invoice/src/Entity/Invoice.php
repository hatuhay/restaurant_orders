<?php

namespace Drupal\restaurant_invoice\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Invoice entity.
 *
 * @ingroup restaurant_invoice
 *
 * @ContentEntityType(
 *   id = "restaurant_invoice",
 *   label = @Translation("Invoice"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\restaurant_invoice\InvoiceListBuilder",
 *     "views_data" = "Drupal\restaurant_invoice\Entity\InvoiceViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\restaurant_invoice\Form\InvoiceForm",
 *       "add" = "Drupal\restaurant_invoice\Form\InvoiceForm",
 *       "edit" = "Drupal\restaurant_invoice\Form\InvoiceForm",
 *       "delete" = "Drupal\restaurant_invoice\Form\InvoiceDeleteForm",
 *     },
 *     "access" = "Drupal\restaurant_invoice\InvoiceAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\restaurant_invoice\InvoiceHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "restaurant_invoice",
 *   admin_permission = "administer invoice entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/restaurant/invoice/{restaurant_invoice}",
 *     "add-form" = "/admin/restaurant/invoice/add",
 *     "edit-form" = "/admin/restaurant/invoice/{restaurant_invoice}/edit",
 *     "delete-form" = "/restaurant/invoice/{restaurant_invoice}/delete",
 *     "collection" = "/restaurant/invoice",
 *   },
 *   field_ui_base_route = "restaurant_invoice.settings"
 * )
 */
class Invoice extends ContentEntityBase implements InvoiceInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
      'table' => \Drupal::request()->query->get('table'),
      'payment_date' => date('d-m-Y'),
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
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCurrency() {
    return $this->get('currency')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function setCurrencyCode($currency_code) {
    $this->set('currency', $currency_code);

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCurrencyCode() {
    return $this->get('currency')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function getLineItems() {
    $line_items = [];
    foreach ($this->get('line_items') as $field_item) {
      $line_item = $field_item->getContainedPluginInstance();
      if ($line_item) {
        $line_items[$line_item->getName()] = $line_item;
      }
    }

    return $line_items;
  }

  /**
   * {@inheritdoc}
   */
  public function getLineItem($name) {
    $line_items = $this->getLineItems();
    foreach ($line_items as $delta => $line_item) {
      if ($line_item->getName() == $name) {
        return $line_item;
      }
    }
    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getAmount() {
    $total = 0;
    foreach ($this->getLineItems() as $line_item) {
      $total = bcadd($total, $line_item->getAmount(), 6);
    }

    return $total;
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
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Invoice entity.'))
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
        'weight' => 0,
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
      ->setLabel(t('Number'))
      ->setDescription(t('The number of the invoice.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => 1,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 1,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['type'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Type'))
      ->setSetting('target_type', 'invoice_type')
      ->setSetting('handler', 'default')
      ->setTranslatable(FALSE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'entity_reference_label',
        'weight' => 4,
        'settings' => [
          'link' => TRUE,
        ],
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_buttons',
        'weight' => 4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['customer'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Customer'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'restaurant_customer')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'weight' => 5,
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

    $fields['line_item'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Line Item'))
      ->setSetting('target_type', 'restaurant_line_item')
      ->setSetting('handler', 'default')
      ->setSetting('cardinality', '-1')
      ->setTranslatable(FALSE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'entity_reference_label',
        'weight' => 50,
        'settings' => [
          'link' => TRUE,
        ],
      ])
      ->setDisplayOptions('form', [
        'type' => 'inline_entity_form_simple',
        'weight' => 50,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);


    $fields['table'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Table'))
      ->setSetting('handler', 'default')
      ->setSetting('target_type', 'restaurant_table')
      ->setTranslatable(FALSE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'entity_reference_label',
        'weight' => 8,
        'settings' => [
          'link' => FALSE,
        ],
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => 8,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['payment'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Payment Type'))
      ->setSetting('target_type', 'payment')
      ->setSetting('handler', 'default')
      ->setTranslatable(FALSE)
      ->setDisplayOptions('view', [
        'weight' => 60,
        'settings' => [
          'link' => FALSE,
        ],
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => 60,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Invoice Status'))
      ->setSetting('target_type', 'invoice_status')
      ->setSetting('handler', 'default')
      ->setTranslatable(FALSE)
      ->setDisplayOptions('view', [
        'weight' => 65,
        'settings' => [
          'link' => FALSE,
        ],
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => 65,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['currency'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Currency'))
      ->setSetting('target_type', 'currency')
      ->setSetting('handler', 'default')
      ->setDefaultValueCallback('Drupal\restaurant_orders\Controller\CurrencyHelper::getDefaultCurrency')
      ->setReadOnly(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'currency_sign',
        'weight' => 10,
        'settings' => [
          'link' => FALSE,
        ],
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['amount'] = BaseFieldDefinition::create('decimal')
      ->setLabel(t('Total amount'))
      ->setRequired(TRUE)
      ->setDefaultValue(0)
      ->setSettings([
        'precision' => 19,
        'scale' => 2,
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'currency_amount',
        'weight' => 15,
      ])
      ->setDisplayOptions('form', [
        'weight' => 15,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['tax_amount'] = BaseFieldDefinition::create('decimal')
      ->setLabel(t('Tax Amount'))
      ->setRequired(TRUE)
      ->setDefaultValue(0)
      ->setSettings([
        'precision' => 19,
        'scale' => 2,
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'currency_amount',
        'weight' => 14,
      ])
      ->setDisplayOptions('form', [
        'weight' => 14,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['payment_reference'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Payment Reference'))
      ->setDescription(t('Payment reference.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => 20,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['payment_date'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Payment Date'))
      ->setDescription(t('Payment date.'))
      ->setDefaultValueCallback('Drupal\restaurant_orders\Controller\CurrencyHelper::getDefaultCurrency')
      ->setSettings([
        'datetime_type' => 'date',
        'text_processing' => 0,
        'default_value_input' => 'now',
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'datetime_default',
        'weight' => 25,
        'settings' => [
        ],
      ])
      ->setDisplayOptions('form', [
        'type' => 'datetime_default',
        'weight' => 25,
        'settings' => [
          'format_type' => 'html_date',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['notes'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Note'))
      ->setDescription(t('Any special note on invoice.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => 100,
      ])
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'settings' => array(
          'rows' => 4,
        ),
        'weight' => 100,
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
