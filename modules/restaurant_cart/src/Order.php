<?php

namespace Drupal\restaurant_cart\Cart;

use Drupal\payment\Payment;
use Drupal\payment\Plugin\Payment\Method\PaymentMethodInterface;

/**
 * Utility functions for cart management.
 */
class Order {

  /**
   * Creates a payment.
   *
   * @param integer $uid
   *   The user ID of the payment's owner.
   * @param \Drupal\payment\Plugin\Payment\Method\PaymentMethodInterface|null $payment_method
   *
   * @return \Drupal\payment\Entity\PaymentInterface
   */
  static function createPayment($uid, PaymentMethodInterface $payment_method = NULL, $line_items) {
    if (!$payment_method) {
      $payment_method = Payment::methodManager()->createInstance('payment_unavailable');
    }
    /** @var \Drupal\payment\Entity\PaymentInterface $payment */
    $payment = entity_create('payment', array(
      'bundle' => 'payment_unavailable',
    ));
    /** @var \Drupal\currency\ConfigImporterInterface $config_importer */
    $config_importer = \Drupal::service('currency.config_importer');
    $config_importer->importCurrency('EUR');
    $payment->setCurrencyCode('EUR')
      ->setPaymentMethod($payment_method)
      ->setOwnerId($uid)
      ->setLineItems(static::createPaymentLineItems());

    return $payment;
  }

  /**
   * Creates payment line items.
   *
   * @return \Drupal\payment\Plugin\Payment\LineItem\PaymentLineItemInterface[]
   */
  static function createPaymentLineItems($line_items_array = []) {
    $line_item_manager = Payment::lineItemManager();
    /** @var \Drupal\currency\ConfigImporterInterface $config_importer */
    $config_importer = \Drupal::service('currency.config_importer');
    $config_importer->importCurrency('PEN');
    $config_importer->importCurrency('JPY');
    $config_importer->importCurrency('MGA');
    $line_items = array(
      $line_item_manager->createInstance('payment_basic', [])
        ->setName('foo')
        ->setAmount(9.9)
      // The Dutch guilder has 100 subunits, which is most common, but is no
      // longer in circulation.
        ->setCurrencyCode('PEN')
        ->setDescription(static::getRandom()->string()),
      $line_item_manager->createInstance('payment_basic', [])
        ->setName('bar')
        ->setAmount(5.5)
      // The Japanese yen has 1000 subunits.
        ->setCurrencyCode('JPY')
        ->setQuantity(2)
        ->setDescription(static::getRandom()->string()),
      $line_item_manager->createInstance('payment_basic', [])
        ->setName('baz')
        ->setAmount(1.1)
      // The Malagasy ariary has 5 subunits, which is non-decimal.
        ->setCurrencyCode('MGA')
        ->setQuantity(3)
        ->setDescription(static::getRandom()->string()),
    );

    return $line_items;
  }

/** 
 *     $configuration = array(
 *      'currency_code' => NULL,
 *      'name' => NULL,
 *      'quantity' => 1,
 *      'amount' => 0,
 *      'description' => NULL,
 *    );
 */

}