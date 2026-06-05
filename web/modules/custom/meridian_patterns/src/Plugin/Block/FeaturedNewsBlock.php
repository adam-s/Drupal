<?php

namespace Drupal\meridian_patterns\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * A "featured + recent news" block — a common web pattern, original implementation.
 *
 * @Block(
 *   id = "meridian_featured_news",
 *   admin_label = @Translation("Featured + recent news")
 * )
 */
class FeaturedNewsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $storage = \Drupal::entityTypeManager()->getStorage('node');
    $ids = $storage->getQuery()
      ->condition('type', 'news')
      ->condition('status', 1)
      ->sort('created', 'DESC')
      ->range(0, 5)
      ->accessCheck(TRUE)
      ->execute();
    $nodes = array_values($storage->loadMultiple($ids));

    $fileUrl = \Drupal::service('file_url_generator');
    $dateFmt = \Drupal::service('date.formatter');

    $map = function ($n) use ($fileUrl, $dateFmt) {
      $image = NULL;
      if ($n->hasField('field_image') && !$n->get('field_image')->isEmpty()) {
        $file = $n->get('field_image')->entity;
        if ($file) {
          $image = $fileUrl->generateAbsoluteString($file->getFileUri());
        }
      }
      return [
        'title' => $n->label(),
        'url' => $n->toUrl()->toString(),
        'date' => $dateFmt->format($n->getCreatedTime(), 'custom', 'M j, Y'),
        'image' => $image,
      ];
    };

    $featured = $nodes ? $map(array_shift($nodes)) : NULL;
    $items = array_map($map, $nodes);

    return [
      '#theme' => 'featured_news',
      '#heading' => 'The latest from Meridian',
      '#featured' => $featured,
      '#items' => $items,
      '#topics' => ['research' => 'Research', 'campus' => 'Campus & Community', 'arts' => 'Arts & Humanities', 'health' => 'Health & Medicine'],
      '#cache' => ['tags' => ['node_list:news'], 'contexts' => ['url.path']],
    ];
  }

}
