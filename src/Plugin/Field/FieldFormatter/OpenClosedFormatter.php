<?php

namespace Drupal\opening_hours\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'opening_hours_open_closed' formatter.
 *
 * @FieldFormatter(
 *   id = "opening_hours_open_closed",
 *   label = @Translation("Open/Closed"),
 *   field_types = {
 *     "opening_hours"
 *   }
 * )
 */
class OpenClosedFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      /** @var \Spatie\OpeningHours\OpeningHours $opening_hours */
      $opening_hours = $item->getOpeningHours();

      $elements[$delta] = [
        '#markup' => $opening_hours->isOpen() ? $this->t('Open') : $this->t('Closed'),
      ];
    }

    return $elements;
  }

}
