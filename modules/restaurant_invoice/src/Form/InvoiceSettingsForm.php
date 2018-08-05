<?php

namespace Drupal\restaurant_invoice\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\restaurant_orders\Controller\RestaurantHelper;

/**
 * Class ProductSettingsForm.
 *
 * @ingroup restaurant_product
 */
class InvoiceSettingsForm extends ConfigFormBase {

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'restaurant_invoice_settings';
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
    $config = $this->config('restaurant_invoice.settings');

    $form["customer"] = [
      '#type' => 'select',
      '#title' => $this->t('Default Customer'),
      '#options' => RestaurantHelper::EntityOptions('restaurant_customer'),
      '#default_value' => $config->get('customer'),
      '#required' => TRUE,
    ];
    $form["payment"] = array(
      '#type' => 'select',
      '#options' => RestaurantHelper::EntityConfigOptions('payment'),
      '#title' => $this->t('Default Payment Option'),
      '#default_value' => $config->get('payment'),
      '#maxlength' => 255,
      '#required' => TRUE,
    );
    $form["type"] = array(
      '#type' => 'select',
      '#options' => RestaurantHelper::EntityConfigOptions('invoice_type'),
      '#title' => $this->t('Default Invoice Type'),
      '#default_value' => $config->get('type'),
      '#maxlength' => 255,
      '#required' => TRUE,
    );
    $form["status"] = array(
      '#type' => 'select',
      '#options' => RestaurantHelper::EntityConfigOptions('invoice_status'),
      '#title' => $this->t('Default Invoice Status'),
      '#default_value' => $config->get('status'),
      '#maxlength' => 255,
      '#required' => TRUE,
    );

    return parent::buildForm($form, $form_state);
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
      // Retrieve the configuration
       $this->configFactory->getEditable('restaurant_invoice.settings')
      // Set the submitted configuration setting
      ->set('customer', $form_state->getValue('customer'))
      ->set('type', $form_state->getValue('type'))
      ->set('payment', $form_state->getValue('payment'))
      ->set('status', $form_state->getValue('status'))
      ->save();

    parent::submitForm($form, $form_state);
  }


  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'restaurant_invoice.settings',
    ];
  }

}
