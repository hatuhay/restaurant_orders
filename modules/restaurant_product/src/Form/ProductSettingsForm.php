<?php

namespace Drupal\restaurant_product\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ProductSettingsForm.
 *
 * @ingroup restaurant_product
 */
class ProductSettingsForm extends ConfigFormBase {

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'product_settings';
  }

  /**
   * Defines the settings form for Product entities.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   Form definition array.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('restaurant_product.settings');

    $currency_options = \Drupal::service('currency.form_helper')->getCurrencyOptions();
    reset($currency_options);
    $form['product_settings']["currency"] = [
      '#type' => 'select',
      '#title' => $this->t('Default Currency'),
      '#options' => \Drupal::service('currency.form_helper')->getCurrencyOptions(),
      '#default_value' => key($currency_options),
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'restaurant_product.settings',
    ];
  }

}
