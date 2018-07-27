<?php

namespace Drupal\restaurant_orders;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of Table entities.
 */
class TableListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Table');
    $header['id'] = $this->t('Machine name');
    $header['table_zone'] = $this->t('Table zone');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['label'] = $entity->label();
    $row['id'] = $entity->id();
    $row['table_zone'] = $entity->tableZone();
    return $row + parent::buildRow($entity);
  }

}
