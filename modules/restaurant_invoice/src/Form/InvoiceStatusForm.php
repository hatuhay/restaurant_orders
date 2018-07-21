<?php

namespace Drupal\restaurant_invoice\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class InvoiceStatusForm.
 */
class InvoiceStatusForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $invoice_status = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $invoice_status->label(),
      '#description' => $this->t("Label for the Invoice status."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $invoice_status->id(),
      '#machine_name' => [
        'exists' => '\Drupal\restaurant_invoice\Entity\InvoiceStatus::load',
      ],
      '#disabled' => !$invoice_status->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $invoice_status = $this->entity;
    $status = $invoice_status->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Invoice status.', [
          '%label' => $invoice_status->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Invoice status.', [
          '%label' => $invoice_status->label(),
        ]));
    }
    $form_state->setRedirectUrl($invoice_status->toUrl('collection'));
  }

}
