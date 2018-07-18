<?php

namespace Drupal\restaurant_invoice\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Invoice edit forms.
 *
 * @ingroup restaurant_invoice
 */
class InvoiceForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\restaurant_invoice\Entity\Invoice */
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
        drupal_set_message($this->t('Created the %label Invoice.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Invoice.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.restaurant_invoice.canonical', ['restaurant_invoice' => $entity->id()]);
  }

}
