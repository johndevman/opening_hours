<?php

namespace Drupal\opening_hours\Plugin\Validation\Constraint;

use Spatie\OpeningHours\Exceptions\InvalidTimeRangeString;
use Spatie\OpeningHours\TimeRange;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the Hours constraint.
 */
class HoursConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($value, Constraint $constraint) {
    // Ignore empty values.
    if (empty($value['hours'])) {
      return;
    }

    try {
      $time_range = TimeRange::fromString($value['hours']);
    } catch (InvalidTimeRangeString $e) {
      $this->context->buildViolation($constraint->invalidTimeRange)
        ->atPath('hours')
        ->addViolation();
    }
  }

}
