<?php

namespace Drupal\restaurant_customer\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Customer edit forms.
 *
 * @ingroup restaurant_customer
 */
class CustomerForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\restaurant_customer\Entity\Customer */
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
        drupal_set_message($this->t('Created the %label Customer.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Customer.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.restaurant_customer.canonical', ['restaurant_customer' => $entity->id()]);
  }

}
