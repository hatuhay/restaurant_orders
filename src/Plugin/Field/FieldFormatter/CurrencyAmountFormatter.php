<?php

namespace Drupal\restaurant_orders\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\NumericFormatterBase;
use Drupal\currency\Plugin\Currency\AmountFormatter\AmountFormatterInterface;
use Drupal\restaurant_orders\Controller\CurrencyHelper;

/**
 * Plugin implementation of the 'currency_amount' formatter.
 *
 * The 'Default' formatter is different for integer fields on the one hand, and
 * for decimal and float fields on the other hand, in order to be able to use
 * different settings.
 *
 * @FieldFormatter(
 *   id = "currency_amount",
 *   label = @Translation("Currency Amount"),
 *   description = @Translation("Formats currency amount using locale settings"),
 *   field_types = {
 *     "decimal",
 *     "float"
 *   }
 * )
 */
class CurrencyAmountFormatter extends NumericFormatterBase {

  /**
   * {@inheritdoc}
   */
  protected function numberFormat($number) {
    $currency = CurrencyHelper::getDefaultCurrency();
    $amount = new AmountFormatterInterface();
    return $amount->formatAmount($currency, $number);
  }

}