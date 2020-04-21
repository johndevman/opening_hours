<?php

namespace Drupal\opening_hours\TypedData;

use Drupal\Core\TypedData\ComplexDataDefinitionBase;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Opening hours day data definition.
 */
class OpeningHoursDayDefinition extends ComplexDataDefinitionBase {

  /**
   * {@inheritdoc}
   */
  public function getPropertyDefinitions() {
    if (!isset($this->propertyDefinitions)) {
      $this->propertyDefinitions = [];

      $this->propertyDefinitions['hours'] = DataDefinition::create('string')
        ->setLabel(t('Hours'));
      $this->propertyDefinitions['data'] = DataDefinition::create('string')
        ->setLabel(t('Data'));
    }
    return $this->propertyDefinitions;
  }

}
