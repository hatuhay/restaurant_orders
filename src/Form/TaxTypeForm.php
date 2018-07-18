<?php

namespace Drupal\restaurant_orders\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class TaxTypeForm.
 */
class TaxTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $restaurant_tax_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $restaurant_tax_type->label(),
      '#description' => $this->t("Label for the Tax type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $restaurant_tax_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\restaurant_orders\Entity\TaxType::load',
      ],
      '#disabled' => !$restaurant_tax_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $restaurant_tax_type = $this->entity;
    $status = $restaurant_tax_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Tax type.', [
          '%label' => $restaurant_tax_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Tax type.', [
          '%label' => $restaurant_tax_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($restaurant_tax_type->toUrl('collection'));
  }

}
