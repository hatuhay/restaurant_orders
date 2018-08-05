<?php

namespace Drupal\restaurant_invoice\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Entity\EntityStorageInterface;

/**
 * Defines the Payment entity.
 *
 * @ConfigEntityType(
 *   id = "payment",
 *   label = @Translation("Payment"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\restaurant_invoice\PaymentListBuilder",
 *     "form" = {
 *       "add" = "Drupal\restaurant_invoice\Form\PaymentForm",
 *       "edit" = "Drupal\restaurant_invoice\Form\PaymentForm",
 *       "delete" = "Drupal\restaurant_invoice\Form\PaymentDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\restaurant_invoice\PaymentHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "payment",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "default_status" = "default_status",
 *     "weight" = "weight",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/payment/{payment}",
 *     "add-form" = "/admin/structure/payment/add",
 *     "edit-form" = "/admin/structure/payment/{payment}/edit",
 *     "delete-form" = "/admin/structure/payment/{payment}/delete",
 *     "collection" = "/admin/structure/payment"
 *   }
 * )
 */
class Payment extends ConfigEntityBase implements PaymentInterface {

  /**
   * The Payment ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Payment label.
   *
   * @var string
   */
  protected $label;

  /**
   * The Payment Default Status.
   *
   * @var string
   */
  protected $default_status;

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
  public function getStatus() {
    return $this->get('default_status');
  }

  /**
   * {@inheritdoc}
   */
  public function getStatusLabel() {
    $statusId = $this->get('default_status');
    $status = \Drupal::entityTypeManager()->getStorage('payment_status')->load($statusId);
    return $status->label();
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

    if (!isset($this->weight) && ($payments = $storage->loadMultiple())) {
      // Set a role weight to make this new role last.
      $max = array_reduce($payments, function ($max, $payment) {
        return $max > $payment->weight ? $max : $payment->weight;
      });
      $this->weight = $max + 1;
    }

  }

}
