<?php

namespace Drupal\restaurant_orders\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\restaurant_orders\Controller\RestaurantHelper;

/**
 * Class TaxForm.
 */
class TaxForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    $tax_options = RestaurantHelper::TaxTypeOptions();
    $restaurant_tax = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Short Label'),
      '#maxlength' => 255,
      '#default_value' => $restaurant_tax->label(),
      '#description' => $this->t("Short label for the Tax."),
      '#required' => TRUE,
    ];

    $form['description'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Description'),
      '#maxlength' => 255,
      '#default_value' => $restaurant_tax->get(description),
      '#description' => $this->t("Description for the Tax."),
      '#required' => TRUE,
    ];

    $form['tax_type'] = array(
      '#type' => 'select',
      '#options' => $tax_options,
      '#title' => $this->t('Tax Type'),
      '#maxlength' => 255,
      '#default_value' => $restaurant_tax->get(tax_type),
      '#description' => $this->t("The tax type."),
      '#required' => TRUE,
    );

    $form['percent'] = array(
      '#type' => 'textfield',
      '#title' => $this
        ->t('Percentage'),
      '#description' => $this->t("Tax value expressed in decimal format (example: 0.18"),
      '#default_value' => $restaurant_tax->get(percent),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
    );

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $restaurant_tax->id(),
      '#machine_name' => [
        'exists' => '\Drupal\restaurant_orders\Entity\Tax::load',
      ],
      '#disabled' => !$restaurant_tax->isNew(),
    ];

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
