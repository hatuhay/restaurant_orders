<?php

namespace Drupal\restaurant_invoice\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\restaurant_orders\Controller\RestaurantHelper;

/**
 * Class PaymentForm.
 */
class PaymentForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $payment = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $payment->label(),
      '#description' => $this->t("Label for the Payment."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $payment->id(),
      '#machine_name' => [
        'exists' => '\Drupal\restaurant_invoice\Entity\Payment::load',
      ],
      '#disabled' => !$payment->isNew(),
    ];

    $form['default_status'] = array(
      '#type' => 'select',
      '#options' => RestaurantHelper::EntityConfigOptions('payment_status'),
      '#title' => $this->t('Dafault Status'),
      '#maxlength' => 255,
      '#default_value' => $payment->get(default_status),
      '#description' => $this->t("The payment default status."),
      '#required' => TRUE,
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $payment = $this->entity;
    $status = $payment->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Payment.', [
          '%label' => $payment->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Payment.', [
          '%label' => $payment->label(),
        ]));
    }
    $form_state->setRedirectUrl($payment->toUrl('collection'));
  }

}
