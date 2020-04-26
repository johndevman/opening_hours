<?php

namespace Drupal\opening_hours\Plugin\Field\FieldWidget;

use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

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
    $field_name = $this->fieldDefinition->getName();
    $parents = $form['#parents'];

    $item = $items[$delta];

    /** @var \Drupal\opening_hours\Plugin\DataType\OpeningHours $opening_hours */
    $opening_hours = $item->get('opening_hours');

    $field_state = static::getWidgetState($parents, $field_name, $form_state);

    $id_suffix = $parents ? '-' . implode('-', $parents) : '';

    $element += [
      '#type' => 'fieldset',
      '#title' => $this->t('Opening hours'),
      'opening_hours' => [
        '#type' => 'container',
        '#tree' => TRUE,
      ],
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
      $wrapper_id = "$field_name-opening-hours-day-$day-wrapper$id_suffix";

      $element['opening_hours'][$day] = [
        '#type' => 'fieldset',
        '#title' => $this->t(ucfirst($day)),
        'items' => [
          '#type' => 'container',
        ],
        '#prefix' => '<div id="' . $wrapper_id . '">',
        '#suffix' => '</div>',
        '#tree' => TRUE,
      ];

      $item_count = $field_state['days'][$day] ?? FALSE;

      if ($item_count === FALSE) {
        $item_count = count($opening_hours->get($day));
        $field_state['days'][$day] = $item_count;

        static::setWidgetState($parents, $field_name, $form_state, $field_state);
      }

      for ($i = 0; $i <= $item_count; $i++) {

        $day_property = $opening_hours->get($day);

        if (!$day_property->get($i)) {
          $day_property->appendItem();
        }

        $element['opening_hours'][$day][$i] = [
          '#type' => 'container',
        ];
        $element['opening_hours'][$day][$i]['hours'] = [
          '#type' => 'textfield',
          '#title' => $this->t('Hours'),
          '#default_value' => $day_property->get($i)->get('hours')->getValue(),
        ];
      }

      $element['opening_hours'][$day]['add_button'] = [
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

    $exception_count = $field_state['exception_count'] ?? FALSE;

    if ($exception_count === FALSE) {
      $exception_count = count($opening_hours->get('exceptions'));
      $field_state['exception_count'] = $exception_count;

      static::setWidgetState($parents, $field_name, $form_state, $field_state);
    }

    $exceptions_wrapper_id = "$field_name-opening-hours-exceptions-wrapper$id_suffix";

    $element['opening_hours']['exceptions'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Exceptions'),
      '#prefix' => '<div id="' . $exceptions_wrapper_id . '">',
      '#suffix' => '</div>',
    ];

    $exceptions = $opening_hours->get('exceptions');

    for ($i = 0; $i <= $exception_count; $i++) {
      $exception = $exceptions->get($i);

      if (!$exception) {
        $exceptions->appendItem();
        $exception = $exceptions->get($i);
      }

      $element['opening_hours']['exceptions'][$i] = [
        '#type' => 'container',
      ];
      $element['opening_hours']['exceptions'][$i]['date'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Date'),
        '#default_value' => $exception->get('date')->getValue(),
      ];
      $element['opening_hours']['exceptions'][$i]['hours'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Hours'),
        '#default_value' => $exception->get('hours')->getValue(),
      ];
    }

    $element['opening_hours']['exceptions']['add_button'] = [
      '#type' => 'submit',
      '#name' => 'exception-add-button',
      '#value' => $this->t('Add more'),
      '#ajax' => [
        'callback' => [static::class, 'updateWidget'],
        'wrapper' => $exceptions_wrapper_id,
      ],
      '#submit' => [[static::class, 'addException']],
      '#limit_validation_errors' => [],
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function errorElement(array $element, ConstraintViolationInterface $error, array $form, FormStateInterface $form_state) {
    return NestedArray::getValue($element, $error->arrayPropertyPath);
  }

  public static function updateWidget(array $form, FormStateInterface $form_state) {
    $button = $form_state->getTriggeringElement();

    $element = NestedArray::getValue($form, array_slice($button['#array_parents'], 0, -1));

    return $element;
  }

  public static function addItem(array $form, FormStateInterface $form_state) {
    $button = $form_state->getTriggeringElement();

    $day = $button['#day'];

    $element = NestedArray::getValue($form, array_slice($button['#array_parents'], 0, -4));
    $field_name = $element['#field_name'];
    $parents = $element['#field_parents'];

    $field_state = static::getWidgetState($parents, $field_name, $form_state);
    $field_state['days'][$day] += 1;
    static::setWidgetState($parents, $field_name, $form_state, $field_state);

    $form_state->setRebuild();
  }

  public static function addException(array $form, FormStateInterface $form_state) {
    $button = $form_state->getTriggeringElement();

    $element = NestedArray::getValue($form, array_slice($button['#array_parents'], 0, -4));
    $field_name = $element['#field_name'];
    $parents = $element['#field_parents'];

    $field_state = static::getWidgetState($parents, $field_name, $form_state);
    $field_state['exception_count'] += 1;
    static::setWidgetState($parents, $field_name, $form_state, $field_state);

    $form_state->setRebuild();
  }

  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    $days = [
      'monday',
      'tuesday',
      'wednesday',
      'thursday',
      'friday',
      'saturday',
      'sunday',
    ];

    // Filter empty values.
    foreach ($values as $delta => $v) {
      foreach ($days as $day) {
        unset($values[$delta]['opening_hours'][$day]['add_button']);
        $values[$delta]['opening_hours'][$day] = array_filter($values[$delta]['opening_hours'][$day], function ($item) {
          return !empty($item['hours']);
        });

        unset($values[$delta]['opening_hours']['exceptions']['add_button']);
        $values[$delta]['opening_hours']['exceptions'] = array_filter($values[$delta]['opening_hours']['exceptions'], function ($exception) {
          return !empty($exception['date']);
        });
      }
    }

    return $values;
  }

}
