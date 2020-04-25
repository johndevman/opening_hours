<?php

namespace Drupal\opening_hours\Plugin\DataType;

use Drupal\Core\TypedData\Plugin\DataType\Map;

/**
 * @DataType(
 *   id = "opening_hours_exception",
 *   label = @Translation("Opening hours exception"),
 *   constraints = {},
 *   definition_class = "\Drupal\opening_hours\TypedData\OpeningHoursExceptionDefinition"
 * )
 */
class OpeningHoursException extends Map {}
