<?php

namespace Drupal\opening_hours\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Validation constraint for time range strings.
 *
 * @Constraint(
 *   id = "TimeRange",
 *   label = @Translation("Time range", context = "Validation"),
 * )
 */
class TimeRangeConstraint extends Constraint {

  /**
   * Invalid time range message.
   *
   * @var string
   */
  public $invalidTimeRange = 'The value isn\'t a valid time range string. A time string must be a formatted as `H:i-H:i`, e.g. `09:00-18:00`.';

}
