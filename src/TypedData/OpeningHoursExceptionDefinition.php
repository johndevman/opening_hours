<?php

namespace Drupal\opening_hours\TypedData;

use Drupal\Core\TypedData\ComplexDataDefinitionBase;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\ListDataDefinition;

/**
 * Opening hours exception data definition.
 */
class OpeningHoursExceptionDefinition extends ComplexDataDefinitionBase {

  /**
   * {@inheritdoc}
   */
  public function getPropertyDefinitions() {
    if (!isset($this->propertyDefinitions)) {
      $this->propertyDefinitions = [];

      $this->propertyDefinitions['date'] = DataDefinition::create('string')
        ->setLabel(t('Date'));
      $this->propertyDefinitions['hours'] = DataDefinition::create('string')
        ->setLabel(t('Hours'));
    }
    return $this->propertyDefinitions;
  }

  public function getConstraints() {
    $constraints = parent::getConstraints();

    $constraints['Hours'] = [];

    return $constraints;
  }

}
