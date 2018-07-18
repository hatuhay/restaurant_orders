<?php

namespace Drupal\restaurant_customer\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class CustomerTypeForm.
 */
class CustomerTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $restaurant_customer_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $restaurant_customer_type->label(),
      '#description' => $this->t("Label for the Customer type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $restaurant_customer_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\restaurant_customer\Entity\CustomerType::load',
      ],
      '#disabled' => !$restaurant_customer_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $restaurant_customer_type = $this->entity;
    $status = $restaurant_customer_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Customer type.', [
          '%label' => $restaurant_customer_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Customer type.', [
          '%label' => $restaurant_customer_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($restaurant_customer_type->toUrl('collection'));
  }

}
