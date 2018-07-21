<?php

namespace Drupal\restaurant_invoice\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class PaymentStatusForm.
 */
class PaymentStatusForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $payment_status = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $payment_status->label(),
      '#description' => $this->t("Label for the Payment status."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $payment_status->id(),
      '#machine_name' => [
        'exists' => '\Drupal\restaurant_invoice\Entity\PaymentStatus::load',
      ],
      '#disabled' => !$payment_status->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $payment_status = $this->entity;
    $status = $payment_status->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Payment status.', [
          '%label' => $payment_status->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Payment status.', [
          '%label' => $payment_status->label(),
        ]));
    }
    $form_state->setRedirectUrl($payment_status->toUrl('collection'));
  }

}
