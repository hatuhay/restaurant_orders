<?php

namespace Drupal\restaurant_orders\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\restaurant_orders\Controller\RestaurantHelper;

/**
 * Class ProductSettingsForm.
 *
 * @ingroup restaurant_product
 */
class RestaurantSettingsForm extends ConfigFormBase {

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'restaurant_orders_settings';
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
    $config = $this->config('restaurant_orders.settings');

    $currency_options = \Drupal::service('currency.form_helper')->getCurrencyOptions();
    reset($currency_options);
    $form['restaurant_orders_settings']["currency"] = [
      '#type' => 'select',
      '#title' => $this->t('Default Currency'),
      '#options' => \Drupal::service('currency.form_helper')->getCurrencyOptions(),
      '#default_value' => key($currency_options),
      '#required' => TRUE,
    ];
    $tax_options = RestaurantHelper::TaxOptions();
    $form['restaurant_orders_settings']["tax"] = array(
      '#type' => 'select',
      '#options' => $tax_options,
      '#title' => $this->t('Tax'),
      '#maxlength' => 255,
      '#description' => $this->t("The default tax."),
      '#required' => TRUE,
    );

    return parent::buildForm($form, $form_state);
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'restaurant_orders.settings',
    ];
  }

}
