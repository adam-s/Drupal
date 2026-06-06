<?php

namespace Drupal\meridian_feature\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Renders a chosen Feature banner entity as a homepage section.
 *
 * @Block(
 *   id = "meridian_feature_banner_entity",
 *   admin_label = @Translation("Feature banner (entity)")
 * )
 */
class FeatureBannerBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['banner_id' => NULL] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $storage = \Drupal::entityTypeManager()->getStorage('feature_banner');
    $options = [];
    foreach ($storage->loadMultiple() as $banner) {
      $options[$banner->id()] = $banner->label() . ' (#' . $banner->id() . ')';
    }
    $form['banner_id'] = [
      '#type' => 'select',
      '#title' => $this->t('Feature banner'),
      '#description' => $this->t('Which feature banner to render. Leave empty to use the newest published one.'),
      '#options' => $options,
      '#empty_option' => $this->t('- Newest published -'),
      '#default_value' => $this->configuration['banner_id'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['banner_id'] = $form_state->getValue('banner_id') ?: NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $storage = \Drupal::entityTypeManager()->getStorage('feature_banner');

    $banner = NULL;
    if (!empty($this->configuration['banner_id'])) {
      $banner = $storage->load($this->configuration['banner_id']);
    }
    if (!$banner) {
      $ids = $storage->getQuery()
        ->condition('status', 1)
        ->sort('id', 'DESC')
        ->range(0, 1)
        ->accessCheck(TRUE)
        ->execute();
      $banner = $ids ? $storage->load(reset($ids)) : NULL;
    }
    if (!$banner || !$banner->isPublished()) {
      return [];
    }

    return \Drupal\meridian_feature\FeatureBannerBuilder::build($banner);
  }

}
