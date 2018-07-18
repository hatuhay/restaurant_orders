<?php

namespace Drupal\restaurant_line_item;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Line item entity.
 *
 * @see \Drupal\restaurant_line_item\Entity\LineItem.
 */
class LineItemAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\restaurant_line_item\Entity\LineItemInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished line item entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published line item entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit line item entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete line item entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add line item entities');
  }

}
