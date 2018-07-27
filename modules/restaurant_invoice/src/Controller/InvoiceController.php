<?php
namespace Drupal\restaurant_invoice\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\restaurant_invoice\Entity;

/**
 * Class TableOrderController.
 *
 * @package Drupal\restaurant_invoice\Controller
 */
class InvoiceController extends ControllerBase {
  /**
   * Tables.
   *
   * @return array
   *   Return Theme.
   */
  public function add() {
    $invoice = $this->entityManager()->getStorage('restaurant_invoice')->create();
    $form = $this->entityFormBuilder()->getForm($invoice);
    return [
      '#theme' => 'invoice_form',
      '#form' => $form,
    ];
  }

  public function edit($entity) {
    $invoice = $this->entityManager()->getStorage('restaurant_invoice')->load($entity);
    $form = $this->entityFormBuilder()->getForm($invoice);
    return [
      '#theme' => 'invoice_form',
      '#form' => $form,
    ];
  }

}