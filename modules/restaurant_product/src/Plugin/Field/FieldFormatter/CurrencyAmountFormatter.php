<?php

namespace Drupal\restaurant_product\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\NumericFormatterBase;

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
  public static function defaultSettings() {
//    $currency_locale = $this->localeDelegator->resolveCurrencyLocale();
    return array(
      'thousand_separator' => '',//$currency_locale->getGroupingSeparator(),
      'decimal_separator' => '.',//$currency_locale->getDecimalSeparator(),
      'scale' => 2,
      'prefix_suffix' => TRUE,
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);
    $elements['decimal_separator'] = array(
      '#type' => 'select',
      '#title' => t('Decimal marker'),
      '#options' => array(
        '.' => t('Decimal point'),
        ',' => t('Comma'),
      ),
      '#default_value' => $this
        ->getSetting('decimal_separator'),
      '#weight' => 5,
    );
    $elements['scale'] = array(
      '#type' => 'number',
      '#title' => t('Scale', array(), array(
        'context' => 'decimal places',
      )),
      '#min' => 0,
      '#max' => 10,
      '#default_value' => $this
        ->getSetting('scale'),
      '#description' => t('The number of digits to the right of the decimal.'),
      '#weight' => 6,
    );
    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  protected function numberFormat($number) {
    return number_format($number, $this
      ->getSetting('scale'), $this
      ->getSetting('decimal_separator'), $this
      ->getSetting('thousand_separator'));
  }

}