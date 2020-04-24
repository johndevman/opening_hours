<?php

namespace Drupal\opening_hours\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Validation constraint for hours.
 *
 * @Constraint(
 *   id = "Hours",
 *   label = @Translation("Hours", context = "Validation"),
 * )
 */
class HoursConstraint extends Constraint {

  public $invalidTimeRange = 'The string isn\'t a valid time range string. A time string must be a formatted as `H:i-H:i`, e.g. `09:00-18:00`.';

}
