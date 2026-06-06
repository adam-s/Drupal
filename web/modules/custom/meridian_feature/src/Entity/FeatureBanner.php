<?php

namespace Drupal\meridian_feature\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\meridian_feature\FeatureBannerInterface;

/**
 * Defines the Feature banner content entity — an editorial homepage section.
 *
 * Everything (the schema, the fields, the routes) is declared here in code; no
 * Field UI / config is required. The repeating cards are a custom multi-value
 * field type (feature_card) authored inline on this entity's form.
 *
 * @ContentEntityType(
 *   id = "feature_banner",
 *   label = @Translation("Feature banner"),
 *   label_collection = @Translation("Feature banners"),
 *   label_singular = @Translation("feature banner"),
 *   label_plural = @Translation("feature banners"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\meridian_feature\FeatureBannerListBuilder",
 *     "access" = "Drupal\Core\Entity\EntityAccessControlHandler",
 *     "form" = {
 *       "default" = "Drupal\meridian_feature\Form\FeatureBannerForm",
 *       "add" = "Drupal\meridian_feature\Form\FeatureBannerForm",
 *       "edit" = "Drupal\meridian_feature\Form\FeatureBannerForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "feature_banner",
 *   admin_permission = "administer feature banners",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "label" = "heading",
 *     "published" = "status",
 *   },
 *   links = {
 *     "collection" = "/admin/content/feature-banner",
 *     "add-form" = "/admin/content/feature-banner/add",
 *     "edit-form" = "/admin/content/feature-banner/{feature_banner}/edit",
 *     "delete-form" = "/admin/content/feature-banner/{feature_banner}/delete",
 *   },
 * )
 */
class FeatureBanner extends ContentEntityBase implements FeatureBannerInterface {

  use EntityPublishedTrait;

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);
    // Adds the publishing status (status) base field.
    $fields += static::publishedBaseFieldDefinitions($entity_type);

    $fields['eyebrow'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Eyebrow'))
      ->setDescription(t('Small uppercase kicker, e.g. "Medical milestone".'))
      ->setSetting('max_length', 80)
      ->setDisplayOptions('form', ['type' => 'string_textfield', 'weight' => 0])
      ->setDisplayConfigurable('form', TRUE);

    $fields['heading'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Heading'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', ['type' => 'string_textfield', 'weight' => 1])
      ->setDisplayConfigurable('form', TRUE);

    $fields['summary'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Summary'))
      ->setDisplayOptions('form', ['type' => 'string_textarea', 'weight' => 2])
      ->setDisplayConfigurable('form', TRUE);

    $fields['image'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Portrait image'))
      ->setSettings([
        'file_directory' => 'meridian/feature',
        'file_extensions' => 'png jpg jpeg webp',
        'alt_field' => TRUE,
        'alt_field_required' => FALSE,
      ])
      ->setDisplayOptions('form', ['type' => 'image_image', 'weight' => 3])
      ->setDisplayConfigurable('form', TRUE);

    $fields['cta_title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('CTA label'))
      ->setSetting('max_length', 80)
      ->setDefaultValue('Learn more')
      ->setDisplayOptions('form', ['type' => 'string_textfield', 'weight' => 4])
      ->setDisplayConfigurable('form', TRUE);

    $fields['cta_uri'] = BaseFieldDefinition::create('string')
      ->setLabel(t('CTA link (path or URL)'))
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', ['type' => 'string_textfield', 'weight' => 5])
      ->setDisplayConfigurable('form', TRUE);

    $fields['tab_label'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Category tab'))
      ->setDescription(t('The solid tab on the seam, e.g. "Health & Medicine".'))
      ->setSetting('max_length', 120)
      ->setDisplayOptions('form', ['type' => 'string_textfield', 'weight' => 6])
      ->setDisplayConfigurable('form', TRUE);

    $fields['archive_label'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Archive tab label'))
      ->setDescription(t('The overlay tab on the image, e.g. "The feature archive".'))
      ->setSetting('max_length', 120)
      ->setDisplayOptions('form', ['type' => 'string_textfield', 'weight' => 7])
      ->setDisplayConfigurable('form', TRUE);

    $fields['archive_uri'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Archive tab link'))
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', ['type' => 'string_textfield', 'weight' => 8])
      ->setDisplayConfigurable('form', TRUE);

    // The repeating cards — our custom compound field, unlimited cardinality.
    $fields['cards'] = BaseFieldDefinition::create('feature_card')
      ->setLabel(t('Cards'))
      ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED)
      ->setDisplayOptions('form', ['type' => 'feature_card_default', 'weight' => 10])
      ->setDisplayConfigurable('form', TRUE);

    return $fields;
  }

}
