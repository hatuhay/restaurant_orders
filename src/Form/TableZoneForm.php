<?php

namespace Drupal\restaurant_orders\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class TableZoneForm.
 */
class TableZoneForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $restaurant_table_zone = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $restaurant_table_zone->label(),
      '#description' => $this->t("Label for the Table zone."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $restaurant_table_zone->id(),
      '#machine_name' => [
        'exists' => '\Drupal\restaurant_orders\Entity\TableZone::load',
      ],
      '#disabled' => !$restaurant_table_zone->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $restaurant_table_zone = $this->entity;
    $status = $restaurant_table_zone->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Table zone.', [
          '%label' => $restaurant_table_zone->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Table zone.', [
          '%label' => $restaurant_table_zone->label(),
        ]));
    }
    $form_state->setRedirectUrl($restaurant_table_zone->toUrl('collection'));
  }

}
