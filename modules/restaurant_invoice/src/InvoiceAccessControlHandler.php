<?php

namespace Drupal\restaurant_invoice;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Invoice entity.
 *
 * @see \Drupal\restaurant_invoice\Entity\Invoice.
 */
class InvoiceAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\restaurant_invoice\Entity\InvoiceInterface $entity */
    // Fetch information from the node object if possible.

    $status = $entity->isPublished();
    $uid = $entity->getOwnerId();

    switch ($operation) {

      case 'view':
        if (!$status) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished invoice entities')->cachePerPermissions()->addCacheableDependency($entity);
        }
        elseif ($account->hasPermission('view published invoice entities')) {
          return AccessResult::allowed()->cachePerUser();
        } 
        else {
          return AccessResult::allowedIf($status && $account->hasPermission('view own published invoice entities') && $account->isAuthenticated() && $account->id() == $uid)->cachePerPermissions()->addCacheableDependency($entity);
        }
        break;

      case 'update':
        if ($account->hasPermission('edit invoice entities')){
          return AccessResult::allowed()->cachePerUser();
        } 
        else {
          return AccessResult::allowedIf($status && $account->hasPermission('edit own invoice entities') && $account->isAuthenticated() && $account->id() == $uid)->cachePerPermissions();
        }

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete invoice entities')->cachePerPermissions();
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add invoice entities');
  }

}
