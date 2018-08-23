<?php

namespace Drupal\restaurant_product\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ProductCategoryForm.
 */
class ProductCategoryForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $restaurant_product_category = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $restaurant_product_category->label(),
      '#description' => $this->t("Label for the Product category."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $restaurant_product_category->id(),
      '#machine_name' => [
        'exists' => '\Drupal\restaurant_product\Entity\ProductCategory::load',
      ],
      '#disabled' => !$restaurant_product_category->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $restaurant_product_category = $this->entity;
    $status = $restaurant_product_category->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Product category.', [
          '%label' => $restaurant_product_category->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Product category.', [
          '%label' => $restaurant_product_category->label(),
        ]));
    }
    $form_state->setRedirectUrl($restaurant_product_category->toUrl('collection'));
  }

}
