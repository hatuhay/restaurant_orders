<?php

namespace Drupal\restaurant_orders\Controller;

/**
 * @file
 * Contains \Drupal\restaurant_orders\Controller\CurrencyHelper.
 */
use Drupal\Core\Controller\ControllerBase;

/**
 * Transaction Manager.
 */
class CurrencyHelper extends ControllerBase {

  /**
   * Check.
   */
  public static function checkCurrency($currency) {
    $result = 'XXX';
    $currencies = self::formOptions();
    if (isset($currencies[$currency])) {
      $result = $currency;
    }
    return $result;
  }

  /**
   * Check.
   */
  public static function getDefaultCurrency() {
    $currency_id = \Drupal::config('restaurant_orders.settings')->get('currency');
    return self::getCurrency($currency_id);
  }

  /**
   * Check.
   */
  public static function getDefaultCurrencyCode() {
    $currency = self::getDefaultCurrency();
    return $currency->getCurrencyCode();
  }

  /**
   * Check.
   */
  public static function getDefaultCurrencySign() {
    $currency = self::getDefaultCurrency();
    return $currency->getCurrencySign();
  }

  /** 
   * Get Entity Currency
   */
  public static function getCurrency($currency_id) {
    return \Drupal::entityTypeManager()->getStorage("currency")->load($currency_id);
  }

  /**
   * Duble: \Drupal::service('currency.form_helper')->getCurrencyOptions().
   */
  public static function formOptions() {
    $currency_storage = \Drupal::entityManager()->getStorage('currency');
    $currencies = $currency_storage->loadMultiple();
    $curr = [];
    foreach ($currencies as $currency) {
      // Do not show disabled currencies.
      if ($currency->status()) {
        $options[$currency->id()] = t('@currency_title (@currency_code)', [
          '@currency_title' => $currency->label(),
          '@currency_code' => $currency->id(),
        ]);
      }
    }
    natcasesort($options);

    return $options;
  }

}
