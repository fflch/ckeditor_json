<?php

namespace Drupal\ckeditor_json\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginBase;
use Drupal\editor\Entity\Editor;


/**
 * Defines the "ckeditor_json" plugin.
 *
 * @CKEditorPlugin(
 *   id = "ckeditor_json",
 *   label = @Translation("CKEditor Json Button")
 * )
 */
#class CkeditorJson extends CKEditorPluginBase implements CKEditorPluginConfigurableInterface {
class CkeditorJson extends CKEditorPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getFile() {
    return drupal_get_path('module', 'ckeditor_json') . '/js/plugin.js';
  }

  /**
   * {@inheritdoc}
   */
  public function getConfig(Editor $editor) {
    return array(
      'dialog_title_insert' => $this->t('Insert Json'),
    );
  }

  /**
   * Implements CKEditorPluginButtonsInterface::getButtons().
   */
  public function getButtons() {
    return array(
      'ckeditor_json_button' => array(
        'label' => $this->t('Ckedito Json'),
        'image' => drupal_get_path('module', 'ckeditor_json') . '/images/json.png',
      ),
    );
  }

}
