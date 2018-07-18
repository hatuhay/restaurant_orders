<?php

namespace Drupal\restaurant_line_item;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Line item entities.
 *
 * @ingroup restaurant_line_item
 */
class LineItemListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Line item ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\restaurant_line_item\Entity\LineItem */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.line_item.edit_form',
      ['line_item' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
