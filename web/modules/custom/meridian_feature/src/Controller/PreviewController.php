<?php

namespace Drupal\meridian_feature\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\meridian_feature\FeatureBannerBuilder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Renders an isolated, fully-styled preview of an unsaved Feature banner.
 *
 * The edit form stashes the entity built from the current form values into the
 * user's private tempstore; this controller renders it into a standalone HTML
 * document that links the yale theme CSS — so the iframe on the edit form shows
 * the section exactly as it will appear, with no admin chrome.
 */
class PreviewController extends ControllerBase {

  /**
   * Output the preview document.
   */
  public function preview(): Response {
    $banner = \Drupal::service('tempstore.private')
      ->get('meridian_feature')
      ->get('preview');

    if (!$banner) {
      return new Response('<!doctype html><meta charset="utf-8"><body style="font:16px/1.5 sans-serif;padding:2rem;color:#555">Nothing to preview yet — click <strong>Preview</strong> on the edit form.</body>');
    }

    $build = FeatureBannerBuilder::build($banner);
    $html = (string) \Drupal::service('renderer')->renderRoot($build);

    $theme_path = \Drupal::service('extension.list.theme')->getPath('yale');
    $css = base_path() . $theme_path . '/css/yale.css';

    $doc = '<!doctype html><html lang="en"><head>'
      . '<meta charset="utf-8">'
      . '<meta name="viewport" content="width=device-width,initial-scale=1">'
      . '<link rel="stylesheet" href="' . $css . '">'
      . '<style>body{margin:0;background:#fff}</style>'
      . '</head><body>' . $html . '</body></html>';

    return new Response($doc);
  }

}
