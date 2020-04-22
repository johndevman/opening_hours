<?php

namespace Drupal\opening_hours\Plugin\Field\FieldWidget;

use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'opening_hours_default' field widget.
 *
 * @FieldWidget(
 *   id = "opening_hours_default",
 *   label = @Translation("Opening hours"),
 *   field_types = {
 *     "opening_hours"
 *   }
 * )
 */
class OpeningHoursWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element += [
      '#type' => 'fieldset',
      '#title' => $this->t('Opening hours'),
    ];

    $days = [
      'monday',
      'tuesday',
      'wednesday',
      'thursday',
      'friday',
      'saturday',
      'sunday',
    ];

    foreach ($days as $day) {

      $wrapper_id = $day . '-day-wrapper';

      $element[$day] = [
        '#type' => 'fieldset',
        '#title' => $this->t(ucfirst($day)),
        'items' => [
          '#type' => 'container',
        ],
        '#prefix' => '<div id="' . $wrapper_id . '">',
        '#suffix' => '</div>',
      ];

      $day_items_count = $form_state->get($day . '_items_count');

      if (!$day_items_count) {
        $form_state->set($day . '_items_count', 1);
        $day_items_count = 1;
      }

      for ($i = 0; $i < $day_items_count; $i++) {
        $element[$day][$i] = [
          '#type' => 'container',
        ];
        $element[$day][$i]['hours'] = [
          '#type' => 'textfield',
          '#title' => $this->t('Hours'),
        ];
      }

      $element[$day]['add_button'] = [
        '#type' => 'submit',
        '#name' => $day . '-add-button',
        '#day' => $day,
        '#value' => $this->t('Add more'),
        '#ajax' => [
          'callback' => [static::class, 'updateWidget'],
          'wrapper' => $wrapper_id,
        ],
        '#submit' => [[static::class, 'addItem']],
        '#limit_validation_errors' => [],
      ];
    }

    $element['exceptions'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Exceptions'),
      'data' => [
        '#type' => 'container',
      ],
    ];

    return $element;
  }

  public static function updateWidget(array $form, FormStateInterface $form_state) {
    $button = $form_state->getTriggeringElement();

    $element = NestedArray::getValue($form, array_slice($button['#array_parents'], 0, -1));

    return $element;
  }

  public static function addItem(array $form, FormStateInterface $form_state) {
    $button = $form_state->getTriggeringElement();

    $day = $button['#day'];

    $day_items_count = $form_state->get($day . '_items_count');
    $form_state->set($day . '_items_count', $day_items_count + 1);

    $form_state->setRebuild();
  }

}
