<?php

namespace Drupal\restaurant_cart\Form;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\payment\Element\PaymentLineItemsInput;
use Drupal\payment\Payment;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PaymentLineItemElement implements ContainerInjectionInterface, FormInterface {

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static();
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'payment_line_item_element';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Nest the element to make sure that works.
    $line_item_manager = Payment::lineItemManager();
    $form['container']['line_item'] = array(
      '#cardinality' => 4,
      '#type' => 'payment_line_items_input',
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $line_items_data = [];
    /** @var \Drupal\payment\Plugin\Payment\LineItem\PaymentLineItemInterface $line_item */
    foreach (PaymentLineItemsInput::getLineItems($form['container']['line_item'], $form_state) as $line_item) {
      $line_items_data[] = array(
        'plugin_id' => $line_item->getPluginId(),
        'plugin_configuration' => $line_item->getConfiguration(),
      );
    }
    \Drupal::state()->set('payment_test_line_item_form_element', $line_items_data);
  }
}
