<?php

namespace Drupal\opening_hours\TypedData;

use Drupal\Core\TypedData\ComplexDataDefinitionBase;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\ListDataDefinition;
use Drupal\Core\TypedData\MapDataDefinition;

/**
 * Opening hours data definition.
 */
class OpeningHoursDataDefinition extends ComplexDataDefinitionBase {

  /**
   * {@inheritdoc}
   */
  public function getPropertyDefinitions() {
    if (!isset($this->propertyDefinitions)) {
      $this->propertyDefinitions = [];

      $this->propertyDefinitions['monday'] = ListDataDefinition::create('opening_hours_day')
        ->setLabel(t('Monday'));
      $this->propertyDefinitions['tuesday'] = ListDataDefinition::create('opening_hours_day')
        ->setLabel(t('Tuesday'));
      $this->propertyDefinitions['wednesday'] = ListDataDefinition::create('opening_hours_day')
        ->setLabel(t('Wednesday'));
      $this->propertyDefinitions['thursday'] = ListDataDefinition::create('opening_hours_day')
        ->setLabel(t('Thursday'));
      $this->propertyDefinitions['friday'] = ListDataDefinition::create('opening_hours_day')
        ->setLabel(t('Friday'));
      $this->propertyDefinitions['saturday'] = ListDataDefinition::create('opening_hours_day')
        ->setLabel(t('Saturday'));
      $this->propertyDefinitions['sunday'] = ListDataDefinition::create('opening_hours_day')
        ->setLabel(t('Sunday'));

      $this->propertyDefinitions['exceptions'] = OpeningHoursDayDefinition::create('opening_hours_day')
        ->setLabel(t('Exceptions'));

      $this->propertyDefinitions['overflow'] = DataDefinition::create('boolean')
        ->setLabel(t('Overflow'));
    }
    return $this->propertyDefinitions;
  }
}
