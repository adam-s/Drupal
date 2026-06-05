<?php

namespace Drupal\meridian_patterns\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * A "feature banner": one featured story + large image + a row of overlay cards.
 * A common magazine/feature web pattern — original implementation.
 *
 * @Block(
 *   id = "meridian_feature_banner",
 *   admin_label = @Translation("Feature banner")
 * )
 */
class FeatureBannerBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $storage = \Drupal::entityTypeManager()->getStorage('node');
    $ids = $storage->getQuery()
      ->condition('type', 'news')
      ->condition('status', 1)
      ->exists('field_image')
      ->sort('created', 'DESC')
      ->range(0, 4)
      ->accessCheck(TRUE)
      ->execute();
    $nodes = array_values($storage->loadMultiple($ids));

    $fileUrl = \Drupal::service('file_url_generator');
    $eyebrows = ['Featured', 'Discovery', 'Community', 'Campus life'];

    $map = function ($n, $i) use ($fileUrl, $eyebrows) {
      $image = NULL;
      if ($n->hasField('field_image') && !$n->get('field_image')->isEmpty() && ($file = $n->get('field_image')->entity)) {
        $image = $fileUrl->generateAbsoluteString($file->getFileUri());
      }
      $summary = '';
      if ($n->hasField('body') && !$n->get('body')->isEmpty()) {
        $summary = mb_substr(trim(strip_tags($n->get('body')->value)), 0, 160);
      }
      return [
        'eyebrow' => $eyebrows[$i % count($eyebrows)],
        'title' => $n->label(),
        'url' => $n->toUrl()->toString(),
        'summary' => $summary,
        'image' => $image,
      ];
    };

    if (!$nodes) {
      return [];
    }
    $featured = $map(array_shift($nodes), 0);
    $cards = [];
    foreach ($nodes as $i => $n) {
      $cards[] = $map($n, $i + 1);
    }

    return [
      '#theme' => 'feature_banner',
      '#tab' => 'Health & Medicine at Meridian',
      '#featured' => $featured,
      '#cards' => $cards,
      '#cache' => ['tags' => ['node_list:news'], 'contexts' => ['url.path']],
    ];
  }

}
