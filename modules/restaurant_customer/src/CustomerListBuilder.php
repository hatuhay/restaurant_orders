<?php

namespace Drupal\restaurant_customer;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Customer entities.
 *
 * @ingroup restaurant_customer
 */
class CustomerListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Customer ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\restaurant_customer\Entity\Customer */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.restaurant_customer.edit_form',
      ['restaurant_customer' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
