<?php

namespace Drupal\opening_hours\TypedData;

use Drupal\Core\TypedData\ComplexDataDefinitionBase;
use Drupal\Core\TypedData\DataDefinition;

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
    }
    return $this->propertyDefinitions;
  }

}
