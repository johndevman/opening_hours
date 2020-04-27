<?php

namespace Drupal\opening_hours\Plugin\DataType;

use Drupal\Core\TypedData\Plugin\DataType\Map;

/**
 * Opening hours data type.
 *
 * @DataType(
 *   id = "opening_hours",
 *   label = @Translation("Opening hours"),
 *   constraints = {},
 *   definition_class = "\Drupal\opening_hours\TypedData\OpeningHoursDefinition"
 * )
 */
class OpeningHours extends Map {}
