<?php

namespace Drupal\Tests\opening_hours\Kernel;

use Drupal\entity_test\Entity\EntityTest;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\field\Entity\FieldConfig;
use Drupal\Tests\field\Kernel\FieldKernelTestBase;

/**
 * Tests 'opening_hours' field type.
 */
class OpeningHoursItemTest extends FieldKernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['opening_hours'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    FieldStorageConfig::create([
      'field_name' => 'field_opening_hours',
      'entity_type' => 'entity_test',
      'type' => 'opening_hours',
    ])->save();

    FieldConfig::create([
      'entity_type' => 'entity_test',
      'field_name' => 'field_opening_hours',
      'bundle' => 'entity_test',
      'settings' => [],
    ])->save();
  }

  /**
   * Tests 'opening_hours' field type.
   */
  public function testOpeningHoursItem() {
    $entity = EntityTest::create([
      'field_opening_hours' => [
        'opening_hours' => [
          'monday'     => ['09:00-12:00', '13:00-18:00'],
          'tuesday'    => ['09:00-12:00', '13:00-18:00'],
          'wednesday'  => ['09:00-12:00'],
          'thursday'   => ['09:00-12:00', '13:00-18:00'],
          'friday'     => ['09:00-12:00', '13:00-20:00'],
          'saturday'   => ['09:00-12:00', '13:00-16:00'],
          'sunday'     => [],
        ],
      ],
    ]);

    /** @var \Spatie\OpeningHours\OpeningHours $opening_hours */
    $opening_hours = $entity->get('field_opening_hours')->get(0)->getOpeningHours();

    $this->assertTrue($opening_hours->isOpenOn('monday'));
    $this->assertTrue($opening_hours->isClosedOn('sunday'));
  }

}
