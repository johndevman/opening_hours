<?php

namespace Drupal\opening_hours\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
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
    $properties['opening_hours'] = DataDefinition::create('any')
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
        ],
      ],
    ];
  }

  public function getOpeningHours() {
    return OpeningHours::create($this->opening_hours);
  }
}
