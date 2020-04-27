<?php

namespace Drupal\opening_hours\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'opening_hours' formatter.
 *
 * @FieldFormatter(
 *   id = "opening_hours",
 *   label = @Translation("Opening hours"),
 *   field_types = {
 *     "opening_hours"
 *   }
 * )
 */
class OpeningHoursFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    $translated_days = [
      'monday' => $this->t('Monday'),
      'tuesday' => $this->t('Tuesday'),
      'wednesday' => $this->t('Wednesday'),
      'thursday' => $this->t('Thursday'),
      'friday' => $this->t('Friday'),
      'saturday' => $this->t('Saturday'),
      'sunday' => $this->t('Sunday'),
    ];

    foreach ($items as $delta => $item) {
      /** @var \Spatie\OpeningHours\OpeningHours $opening_hours */
      $opening_hours = $item->getOpeningHours();

      $week = $opening_hours->forWeek();

      $elements[$delta] = [
        '#type' => 'table',
        '#attributes' => [
          'class' => ['opening-hours'],
        ],
      ];

      /**
       * @var string $day
       * @var \Spatie\OpeningHours\OpeningHoursForDay $opening_hours_for_day
       */
      foreach ($week as $day => $opening_hours_for_day) {
        $elements[$delta][$day]['name'] = ['#markup' => $translated_days[$day]];
        $elements[$delta][$day]['time'] = ['#markup' => (string) $opening_hours_for_day];
      }
    }

    return $elements;
  }

}
