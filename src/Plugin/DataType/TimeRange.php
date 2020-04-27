<?php

namespace Drupal\opening_hours\Plugin\DataType;

use Drupal\Core\TypedData\PrimitiveBase;
use Drupal\Core\TypedData\Type\StringInterface;

/**
 * Time range data type.
 *
 * @DataType(
 *   id = "time_range",
 *   label = @Translation("Time range"),
 *   constraints = {"TimeRange" = {}}
 * )
 */
class TimeRange extends PrimitiveBase implements StringInterface {

  /**
   * {@inheritdoc}
   */
  public function getCastedValue() {
    return $this->getString();
  }

}
