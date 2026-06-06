<?php

namespace Drupal\meridian_feature\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * A compound "feature card" field: eyebrow, heading, summary, image, link, style.
 *
 * Modeled in code (no Paragraphs) so an editor authors each card inline on the
 * Feature banner form. Image is stored as a URL/path string to keep the inline
 * widget dependency-free.
 *
 * @FieldType(
 *   id = "feature_card",
 *   label = @Translation("Feature card"),
 *   description = @Translation("An eyebrow, heading, summary, image, link and style for one card."),
 *   default_widget = "feature_card_default",
 *   default_formatter = "string"
 * )
 */
class FeatureCardItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['eyebrow'] = DataDefinition::create('string')->setLabel(t('Eyebrow'));
    $properties['heading'] = DataDefinition::create('string')->setLabel(t('Heading'));
    $properties['summary'] = DataDefinition::create('string')->setLabel(t('Summary'));
    $properties['image'] = DataDefinition::create('string')->setLabel(t('Image URL'));
    $properties['link_uri'] = DataDefinition::create('string')->setLabel(t('Link URL'));
    $properties['link_title'] = DataDefinition::create('string')->setLabel(t('Link title'));
    $properties['style'] = DataDefinition::create('string')->setLabel(t('Style'));
    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'eyebrow' => ['type' => 'varchar', 'length' => 120],
        'heading' => ['type' => 'varchar', 'length' => 255],
        'summary' => ['type' => 'text', 'size' => 'normal'],
        'image' => ['type' => 'varchar', 'length' => 512],
        'link_uri' => ['type' => 'varchar', 'length' => 512],
        'link_title' => ['type' => 'varchar', 'length' => 120],
        'style' => ['type' => 'varchar', 'length' => 32],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $heading = $this->get('heading')->getValue();
    $image = $this->get('image')->getValue();
    return ($heading === NULL || $heading === '') && ($image === NULL || $image === '');
  }

  /**
   * {@inheritdoc}
   */
  public static function mainPropertyName() {
    return 'heading';
  }

}
