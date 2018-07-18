<?php

namespace Drupal\restaurant_orders\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class TaxForm.
 */
class TaxForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $restaurant_tax = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $restaurant_tax->label(),
      '#description' => $this->t("Label for the Tax."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $restaurant_tax->id(),
      '#machine_name' => [
        'exists' => '\Drupal\restaurant_orders\Entity\Tax::load',
      ],
      '#disabled' => !$restaurant_tax->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $restaurant_tax = $this->entity;
    $status = $restaurant_tax->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Tax.', [
          '%label' => $restaurant_tax->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Tax.', [
          '%label' => $restaurant_tax->label(),
        ]));
    }
    $form_state->setRedirectUrl($restaurant_tax->toUrl('collection'));
  }

}
