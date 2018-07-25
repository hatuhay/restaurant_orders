<?php

/**
 * @file Contains \Drupal\currency\Plugin\Currency\AmountFormatter\Basic.
 */

namespace Drupal\restaurant_orders\Plugin;

use Commercie\Currency\CurrencyInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Plugin\PluginBase;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\currency\LocaleResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Formats amounts using string translation and number_format().
 *
 * @CurrencyAmountFormatter(
 *   description = @Translation("Formats amounts using a translatable string."),
 *   id = "currency_basic",
 *   label = @Translation("Basic")
 * )
 */
class CurrencyAmountFormatSign extends AmountFormatterInterface {

  /**
   * {@inheritdoc}
   */
  public function formatAmount(CurrencyInterface $currency, $amount, $language_type = LanguageInterface::TYPE_CONTENT) {
    // Compute the number of decimals, so we can format all of them and no less
    // or more.
    $decimals = strlen($amount) - strpos($amount, '.') - 1;
    $currency_locale = $this->localeDelegator->resolveCurrencyLocale();
    $formatted_amount = number_format($amount, $decimals, $currency_locale->getDecimalSeparator(), $currency_locale->getGroupingSeparator());
    $arguments = array(
      '@currency_code' => $currency->getCurrencyCode(),
      '@currency_sign' => $currency->getSign(),
      '@amount' => $formatted_amount,
    );

    return $this->t('@currency_sign @amount', $arguments);
  }
}
