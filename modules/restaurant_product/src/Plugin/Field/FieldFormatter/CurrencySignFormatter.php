<?php

namespace Drupal\restaurant_product\Plugin\Field\FieldFormatter;
     
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceFormatterBase;
     
/**
 * Plugin implementation of the 'currency_sign' formatter.
 *
 * @FieldFormatter(
 *   id = "currency_sign",
 *   label = @Translation("Currency sign"),
 *   description = @Translation("Formats currency using currency sign"),
 *   field_types = {
 *     "entity_reference",
 *   }
 * )
 */
class CurrencySignFormatter extends EntityReferenceFormatterBase {
  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
     
    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $entity) {
      $elements[$delta] = array(
        'currency' => array(
          '#markup' => $entity->getSign(),
          ),
      );
    }
     
    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(FieldDefinitionInterface $field_definition) {
    return $field_definition->getFieldStorageDefinition()->getSetting('target_type') == 'currency';
  }

}

