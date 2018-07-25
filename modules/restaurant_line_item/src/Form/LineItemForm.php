<?php

namespace Drupal\restaurant_line_item\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Line item edit forms.
 *
 * @ingroup restaurant_line_item
 */
class LineItemForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\restaurant_line_item\Entity\LineItem */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Line item.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Line item.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.restaurant_line_item.canonical', ['restaurant_line_item' => $entity->id()]);
  }

}
