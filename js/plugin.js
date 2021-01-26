/**
 * @file
 * ckeditor_json plugin.
 *
 * @ignore
 */

(function ($, Drupal, drupalSettings, CKEDITOR) {

    'use strict';
  
    CKEDITOR.plugins.add('ckeditor_json', {
      init: function (editor) {
        editor.addCommand('ckeditor_json', {
          modes: {wysiwyg: 1},
          canUndo: true,
          exec: function (editor) {

            // Prepare a save callback to be used upon saving the dialog.
            var saveCallback = function (returnValues) {
              editor.fire('saveSnapshot');
  
              if (returnValues.attributes.body) {
                var selection = editor.getSelection();
                var range = selection.getRanges(1)[0];
  
                if (range.collapsed) {
                  var values = returnValues.attributes;

                  var container = editor.document.createElement('div');
                  container.setAttribute('class', 'ckeditor-json');
  
                  var header = editor.document.createElement('h1');
                  header.setAttribute('class', 'ckeditor-json-header');

                  header.setHtml('parte de cima');
  
                  var body = editor.document.createElement('p');
                  body.setHtml(values.body);
  
                  container.append(header);
                  container.append(body);
  
                  editor.insertElement(container);

                }
                
              }
  
              // Save snapshot for undo support.
              editor.fire('saveSnapshot');
            };
            // Drupal.t() will not work inside CKEditor plugins because CKEditor
            // loads the JavaScript file instead of Drupal. Pull translated
            // strings from the plugin settings that are translated server-side.
            var dialogSettings = {
              title: editor.config.dialog_title_insert,
              dialogClass: 'ckeditor_json-dialog'
            };
  
            // Open the dialog for the edit form.
            var existingValues = {};
            Drupal.ckeditor.openDialog(editor, Drupal.url('ckeditor_json/dialog'), existingValues, saveCallback, dialogSettings);
          }
        });

        // Add button
        if (editor.ui.addButton) {
          editor.ui.addButton('ckeditor_json_button', {
            label: Drupal.t('Insert ckeditor_json'),
            command: 'ckeditor_json',
            icon: this.path +  '../images/json.png'
          });
        }
  
        // If the "menu" plugin is loaded, register the menu items.
        if (editor.addMenuItems) {
          editor.addMenuItems({
            ckeditor_json: {
              label: Drupal.t('ckeditor_json'),
              command: 'ckeditor_json',
              group: 'tools',
              order: 1
            }
          });
        }
      }
    });
  })(jQuery, Drupal, drupalSettings, CKEDITOR);



  
