<?php

namespace Drupal\Tests\opening_hours\Kernel;

use Drupal\Core\Render\RenderContext;
use Drupal\entity_test\Entity\EntityTest;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\field\Entity\FieldConfig;
use Drupal\Tests\field\Kernel\FieldKernelTestBase;

/**
 * Tests 'opening_hours_open_closed' field formatter.
 */
class OpenClosedFormatterTest extends FieldKernelTestBase {

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
   * Tests the formatter.
   *
   * @dataProvider formatterTestCases
   */
  public function testFormatter($field_value, $expected) {
    $entity = EntityTest::create([
      'field_opening_hours' => $field_value,
    ]);
    $entity->save();

    $actual = $this->container->get('renderer')->executeInRenderContext(new RenderContext(), function () use ($entity) {
      return $entity->field_opening_hours->view(['type' => 'opening_hours_open_closed']);
    });

    $this->assertEquals($expected, $actual[0]);
  }

  /**
   * Test cases for ::testFormatter.
   */
  public function formatterTestCases() {
    return [
      'Open' => [
        [
          'opening_hours' => [
            'monday' => [
              ['hours' => '00:00-23:59'],
            ],
            'tuesday' => [
              ['hours' => '00:00-23:59'],
            ],
            'wednesday' => [
              ['hours' => '00:00-23:59'],
            ],
            'thursday' => [
              ['hours' => '00:00-23:59'],
            ],
            'friday' => [
              ['hours' => '00:00-23:59'],
            ],
            'saturday' => [
              ['hours' => '00:00-23:59'],
            ],
            'sunday' => [
              ['hours' => '00:00-23:59'],
            ],
            'exceptions' => [],
          ],
        ],
        [
          '#markup' => 'Open',
        ],
      ],
      'Closed' => [
        [
          'opening_hours' => [
            'monday' => [],
            'tuesday' => [],
            'wednesday' => [],
            'thursday' => [],
            'friday' => [],
            'saturday' => [],
            'sunday' => [],
            'exceptions' => [],
          ],
        ],
        [
          '#markup' => 'Closed',
        ],
      ],
    ];
  }

}
