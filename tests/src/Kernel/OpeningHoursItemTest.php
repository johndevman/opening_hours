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
          'monday' => [
            ['hours' => '08:00-10:00'],
            ['hours' => '12:00-20:00', 'data' => 'Foo'],
          ],
          'overflow' => FALSE,
        ],
      ],
    ]);

    $this->assertEmpty($entity->validate());

    /** @var \Spatie\OpeningHours\OpeningHours $opening_hours */
    $opening_hours = $entity->get('field_opening_hours')->get(0)->getOpeningHours();

    $this->assertTrue($opening_hours->isOpenOn('monday'));
    $this->assertTrue($opening_hours->isClosedOn('sunday'));
  }

}
