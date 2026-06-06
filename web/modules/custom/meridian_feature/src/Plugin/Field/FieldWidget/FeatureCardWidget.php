<?php

namespace Drupal\meridian_feature\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Inline widget for the feature_card compound field.
 *
 * Each card delta renders as a small fieldset of plain inputs; core's
 * unlimited-cardinality "Add another item" handling wraps them. The sub-element
 * keys match the field columns, so the default massageFormValues maps cleanly.
 *
 * @FieldWidget(
 *   id = "feature_card_default",
 *   label = @Translation("Feature card (inline)"),
 *   field_types = {"feature_card"}
 * )
 */
class FeatureCardWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $item = $items[$delta] ?? NULL;

    $element['#type'] = 'fieldset';
    $element['#title'] = $this->t('Card @n', ['@n' => $delta + 1]);
    $element['#attributes']['class'][] = 'feature-card-widget';

    $element['eyebrow'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Eyebrow'),
      '#default_value' => $item->eyebrow ?? '',
      '#size' => 30,
    ];
    $element['heading'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Heading'),
      '#default_value' => $item->heading ?? '',
    ];
    $element['summary'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Summary'),
      '#default_value' => $item->summary ?? '',
      '#rows' => 2,
    ];
    $element['style'] = [
      '#type' => 'select',
      '#title' => $this->t('Style'),
      '#options' => [
        'photo' => $this->t('Photo background'),
        'solid' => $this->t('Solid color (no image)'),
      ],
      '#default_value' => $item->style ?? 'photo',
    ];
    $element['image'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Image URL'),
      '#description' => $this->t('Path or URL to a background image (used for the Photo style).'),
      '#default_value' => $item->image ?? '',
    ];
    $element['link_uri'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Link URL'),
      '#default_value' => $item->link_uri ?? '',
    ];
    $element['link_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Link title'),
      '#default_value' => $item->link_title ?? '',
      '#size' => 30,
    ];

    return $element;
  }

}
