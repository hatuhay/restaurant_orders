<?php

namespace Drupal\restaurant_invoice\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class InvoiceTypeForm.
 */
class InvoiceTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $invoice_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $invoice_type->label(),
      '#description' => $this->t("Label for the Invoice type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $invoice_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\restaurant_invoice\Entity\InvoiceType::load',
      ],
      '#disabled' => !$invoice_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $invoice_type = $this->entity;
    $status = $invoice_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Invoice type.', [
          '%label' => $invoice_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Invoice type.', [
          '%label' => $invoice_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($invoice_type->toUrl('collection'));
  }

}
