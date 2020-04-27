<?php

namespace Drupal\opening_hours\Plugin\DataType;

use Drupal\Core\TypedData\Plugin\DataType\Map;

/**
 * Opening hours day data type.
 *
 * @DataType(
 *   id = "opening_hours_day",
 *   label = @Translation("Opening hours day"),
 *   constraints = {},
 *   definition_class = "\Drupal\opening_hours\TypedData\OpeningHoursDayDefinition"
 * )
 */
class OpeningHoursDay extends Map {

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    return empty($this->get('hours')->getValue());
  }

}
