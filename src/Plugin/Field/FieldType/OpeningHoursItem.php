<?php

namespace Drupal\opening_hours\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\opening_hours\TypedData\OpeningHoursDataDefinition;
use Spatie\OpeningHours\OpeningHours;

/**
 * Plugin implementation of the 'opening_hours' field type.
 *
 * @FieldType(
 *   id = "opening_hours",
 *   label = @Translation("Opening hours"),
 *   default_widget = "opening_hours_default",
 *   default_formatter = "opening_hours",
 * )
 */
class OpeningHoursItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['opening_hours'] = OpeningHoursDataDefinition::create('opening_hours')
      ->setLabel(t('Opening hours'))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'opening_hours' => [
          'type' => 'blob',
          'not null' => TRUE,
          'size' => 'normal',
          'serialize' => TRUE,
        ],
      ],
    ];
  }

  public function getOpeningHours() {
    $values = $this->opening_hours;

    $exceptions = [];

    foreach ($values['exceptions'] as $exception) {
      $exceptions[$exception['date']] = [];

      if (!empty($exception['hours'])) {
        $exceptions[$exception['date']]['hours'] = [$exception['hours']];
      }
    }

    return OpeningHours::create([
      'monday' => $values['monday'],
      'tuesday' => $values['tuesday'],
      'wednesday' => $values['wednesday'],
      'thursday' => $values['thursday'],
      'friday' => $values['friday'],
      'saturday' => $values['saturday'],
      'sunday' => $values['sunday'],
      'exceptions' => $exceptions,
    ]);
  }
}
