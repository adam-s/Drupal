<?php

namespace Drupal\meridian_patterns\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * A "tiles mosaic": a brand-colored band of unequal, tinted tiles built from
 * mixed site content (news photos, people avatars, research/courses) plus a
 * couple of curated editorial tiles and a shuffle control. A common
 * "explore"/discovery pattern — original implementation.
 *
 * @Block(
 *   id = "meridian_tiles",
 *   admin_label = @Translation("Tiles mosaic")
 * )
 */
class TilesBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $news = $this->load('news', 'field_image', 2);
    $people = $this->load('person', 'field_photo', 2);
    $research = $this->load('research', NULL, 1);
    $course = $this->load('course', NULL, 1);

    $tiles = [];
    // Control tile (explore-by-topic + shuffle) — rendered specially.
    $tiles[] = ['variant' => 'control', 'size' => 'sm'];

    // Large photographic feature tile (newest news with an image).
    if (isset($news[0])) {
      $tiles[] = $news[0] + ['eyebrow' => 'Experiences', 'cta' => 'Explore', 'size' => 'lg', 'photo' => TRUE];
    }
    // Small tinted avatar tile.
    if (isset($people[0])) {
      $tiles[] = $people[0] + ['eyebrow' => 'Faculty', 'cta' => 'Profile', 'size' => 'sm', 'photo' => TRUE, 'tint' => 'tint-orange'];
    }
    // Flat text tile (research) — a color-block accent.
    if (isset($research[0])) {
      $tiles[] = $research[0] + ['eyebrow' => 'Discoveries', 'cta' => 'Learn more', 'size' => 'sm', 'flat' => 'flat-light'];
    }
    // Tall tinted discovery tile (second news with an image).
    if (isset($news[1])) {
      $tiles[] = $news[1] + ['eyebrow' => 'Research', 'cta' => 'Learn more', 'size' => 'tall', 'photo' => TRUE, 'tint' => 'tint-blue'];
    }
    // Small tinted avatar tile.
    if (isset($people[1])) {
      $tiles[] = $people[1] + ['eyebrow' => 'Faculty', 'cta' => 'Profile', 'size' => 'sm', 'photo' => TRUE, 'tint' => 'tint-green'];
    }
    // Flat text tile (course).
    if (isset($course[0])) {
      $tiles[] = $course[0] + ['eyebrow' => 'Teaching', 'size' => 'sm', 'flat' => 'flat-blue'];
    }
    // Curated editorial flat tile — the orange accent.
    $tiles[] = [
      'eyebrow' => 'Institute',
      'title' => 'The Meridian Institute for Discovery',
      'url' => '/research',
      'cta' => 'Learn more',
      'size' => 'sm',
      'flat' => 'flat-orange',
    ];

    return [
      '#theme' => 'tiles_mosaic',
      '#eyebrow' => 'The parts that make Meridian whole',
      '#heading' => 'A closer look for the curious',
      '#topics' => ['research' => 'Research', 'arts' => 'Arts', 'science' => 'Science', 'campus' => 'Campus life'],
      '#tiles' => $tiles,
      '#attached' => ['library' => ['meridian_patterns/tiles']],
      '#cache' => ['tags' => ['node_list'], 'contexts' => ['url.path']],
    ];
  }

  /**
   * Load up to $limit published nodes of a type, mapped to tile data.
   *
   * @param string $type
   *   Content type machine name.
   * @param string|null $imageField
   *   Image field to pull a background from, or NULL for text-only tiles.
   * @param int $limit
   *   Max items.
   */
  protected function load(string $type, ?string $imageField, int $limit): array {
    $storage = \Drupal::entityTypeManager()->getStorage('node');
    $query = $storage->getQuery()
      ->condition('type', $type)
      ->condition('status', 1)
      ->sort('created', 'DESC')
      ->range(0, $limit)
      ->accessCheck(TRUE);
    if ($imageField) {
      $query->exists($imageField);
    }
    $ids = $query->execute();
    if (!$ids) {
      return [];
    }
    $fileUrl = \Drupal::service('file_url_generator');
    $out = [];
    foreach ($storage->loadMultiple($ids) as $node) {
      $image = NULL;
      if ($imageField && !$node->get($imageField)->isEmpty() && ($file = $node->get($imageField)->entity)) {
        $image = $fileUrl->generateAbsoluteString($file->getFileUri());
      }
      $text = '';
      if ($node->hasField('body') && !$node->get('body')->isEmpty()) {
        $text = mb_substr(trim(strip_tags($node->get('body')->value)), 0, 110);
      }
      $out[] = [
        'title' => $node->label(),
        'url' => $node->toUrl()->toString(),
        'image' => $image,
        'text' => $text,
      ];
    }
    return $out;
  }

}
