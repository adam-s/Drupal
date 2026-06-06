<?php

namespace Drupal\meridian_feature;

/**
 * Builds the render array for a Feature banner.
 *
 * Shared by the block plugin (front-end placement) and the preview controller
 * (edit-form iframe) so both render byte-for-byte the same markup.
 */
class FeatureBannerBuilder {

  /**
   * Build the themed render array for one banner entity (saved or unsaved).
   *
   * @param \Drupal\meridian_feature\FeatureBannerInterface $banner
   *   The banner entity (may be an unsaved entity built from form values).
   *
   * @return array
   *   A render array using the meridian_feature_banner theme hook.
   */
  public static function build(FeatureBannerInterface $banner): array {
    $fileUrl = \Drupal::service('file_url_generator');

    $image = NULL;
    if (!$banner->get('image')->isEmpty() && ($file = $banner->get('image')->entity)) {
      $image = $fileUrl->generateAbsoluteString($file->getFileUri());
    }

    $cards = [];
    foreach ($banner->get('cards') as $item) {
      $cards[] = [
        'eyebrow' => $item->eyebrow,
        'heading' => $item->heading,
        'summary' => $item->summary,
        'image' => $item->image,
        'url' => $item->link_uri,
        'link_title' => $item->link_title,
        'style' => $item->style ?: 'photo',
      ];
    }

    return [
      '#theme' => 'meridian_feature_banner',
      '#eyebrow' => $banner->get('eyebrow')->value,
      '#heading' => $banner->label(),
      '#summary' => $banner->get('summary')->value,
      '#image' => $image,
      '#cta_title' => $banner->get('cta_title')->value,
      '#cta_url' => $banner->get('cta_uri')->value,
      '#tab_label' => $banner->get('tab_label')->value,
      '#archive_label' => $banner->get('archive_label')->value,
      '#archive_url' => $banner->get('archive_uri')->value,
      '#cards' => $cards,
      '#cache' => [
        'tags' => $banner->getCacheTags(),
        'contexts' => ['url.path'],
      ],
    ];
  }

}
