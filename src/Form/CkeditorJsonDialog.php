<?php

namespace Drupal\ckeditor_json\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\filter\Entity\FilterFormat;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\editor\Ajax\EditorDialogSave;
use Drupal\Core\Ajax\CloseModalDialogCommand;

use Drupal\ckeditor_json\Utils\JsonContent;

class CkeditorJsonDialog extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'editor_ckeditor_json_dialog';
  }

  /**
   * {@inheritdoc}
   *
   * @param \Drupal\filter\Entity\FilterFormat $filter_format
   *   The filter format for which this dialog corresponds.
   */
  public function buildForm(array $form, FormStateInterface $form_state, FilterFormat $filter_format = NULL) {

    $itens = JsonContent::itens();
    $options = [];
    foreach($itens as $item){
      $options[$item->char_id] = $item->name;
    }
    #img
    #nickname

    $user_input = $form_state->getUserInput();
    $input = isset($user_input['editor_object']) ? $user_input['editor_object'] : array();

    $form['#tree'] = TRUE;
    $form['#attached']['library'][] = 'editor/drupal.editor.dialog';
    $form['#attached']['library'][] = 'ckeditor_json/ckeditor_json.dialog';

    $form['#prefix'] = '<div id="editor-ckeditor-json-dialog-form">';
    $form['#suffix'] = '</div>';

    $form['attributes']['body'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Body'),
      '#default_value' => isset($input['body']) ? $input['body'] : '',
      '#size' => 50,
    );

    $form['attributes']['itens'] = array(
      '#type' => 'checkboxes',
      '#title' => $this->t('Itens'),
      '#options' => $options,
      '#size' => 50,
    );

    $form['actions'] = array(
      '#type' => 'actions',
    );
    $form['actions']['save_modal'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Insert'),
      // No regular submit-handler. This form only works via JavaScript.
      '#submit' => array(),
      '#ajax' => array(
        'callback' => '::submitForm',
        'event' => 'click',
      ),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();

    if ($form_state->getErrors()) {
      unset($form['#prefix'], $form['#suffix']);
      $form['status_messages'] = [
        '#type' => 'status_messages',
        '#weight' => -10,
      ];
      $response->addCommand(new HtmlCommand('#editor-ckeditor-json-dialog-form', $form));
    }
    else {
      $response->addCommand(new EditorDialogSave($form_state->getValues()));
      $response->addCommand(new CloseModalDialogCommand());
    }

    return $response;
  }

}
