<?php

namespace Drupal\meridian_feature\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Add/edit form for the Feature banner entity, with a live iframe preview.
 */
class FeatureBannerForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    // The preview pane — populated by the AJAX callback. Lives last on the form.
    $form['preview_container'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'feature-banner-preview-pane'],
      '#weight' => 1000,
    ];

    if ($form_state->get('show_preview')) {
      // Bust the iframe cache on each Preview click so it reloads fresh.
      $n = (int) $form_state->get('preview_count');
      $src = Url::fromRoute('meridian_feature.preview', [], ['query' => ['n' => $n]])->toString();
      $form['preview_container']['frame'] = [
        '#type' => 'inline_template',
        '#template' => '<div class="fb-preview"><strong>{{ label }}</strong>'
          . '<iframe title="{{ label }}" src="{{ src }}" loading="lazy" '
          . 'style="display:block;width:100%;height:840px;border:1px solid #ccc;margin-top:.5rem;background:#fff"></iframe></div>',
        '#context' => ['label' => $this->t('Live preview'), 'src' => $src],
      ];
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  protected function actions(array $form, FormStateInterface $form_state) {
    $actions = parent::actions($form, $form_state);

    $actions['preview'] = [
      '#type' => 'submit',
      '#value' => $this->t('Preview'),
      // Run validation (so the heading is present) but NOT ::save.
      '#submit' => ['::submitPreview'],
      '#ajax' => [
        'callback' => '::previewAjax',
        'wrapper' => 'feature-banner-preview-pane',
        'progress' => ['type' => 'throbber', 'message' => $this->t('Building preview…')],
      ],
      '#weight' => 5,
    ];

    return $actions;
  }

  /**
   * Submit handler for the Preview button: stash the unsaved entity.
   */
  public function submitPreview(array $form, FormStateInterface $form_state) {
    // Build a populated, UNSAVED entity from the current form values.
    $entity = $this->buildEntity($form, $form_state);
    \Drupal::service('tempstore.private')
      ->get('meridian_feature')
      ->set('preview', $entity);

    $form_state->set('preview_count', (int) $form_state->get('preview_count') + 1);
    $form_state->set('show_preview', TRUE);
    $form_state->setRebuild(TRUE);
  }

  /**
   * AJAX callback: return the (now populated) preview pane.
   */
  public function previewAjax(array $form, FormStateInterface $form_state) {
    return $form['preview_container'];
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);
    $this->messenger()->addStatus($this->t('Saved the %label feature banner.', [
      '%label' => $this->entity->label(),
    ]));
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
    return $result;
  }

}
