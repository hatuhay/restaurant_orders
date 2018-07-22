<?php

namespace Drupal\restaurant_orders\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class TableForm.
 */
class TableForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $reataurant_table = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $reataurant_table->label(),
      '#description' => $this->t("Label for the Table."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $reataurant_table->id(),
      '#machine_name' => [
        'exists' => '\Drupal\restaurant_orders\Entity\Table::load',
      ],
      '#disabled' => !$reataurant_table->isNew(),
    ];

    $form['table_zone'] = array(
      '#type' => 'select',
      '#options' => RestaurantHelper::EntityConfigOptions('table_zone'),
      '#title' => $this->t('Table Zone'),
      '#maxlength' => 255,
      '#default_value' => $restaurant_table->get(table_zone),
      '#description' => $this->t("The zone where the table is located."),
      '#required' => TRUE,
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $reataurant_table = $this->entity;
    $status = $reataurant_table->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Table.', [
          '%label' => $reataurant_table->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Table.', [
          '%label' => $reataurant_table->label(),
        ]));
    }
    $form_state->setRedirectUrl($reataurant_table->toUrl('collection'));
  }

}
