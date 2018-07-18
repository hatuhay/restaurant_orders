<?php

namespace Drupal\restaurant_invoice;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Invoice entities.
 *
 * @ingroup restaurant_invoice
 */
class InvoiceListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Invoice ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\restaurant_invoice\Entity\Invoice */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.restaurant_invoice.edit_form',
      ['restaurant_invoice' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
