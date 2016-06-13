<?php

function recipe_settings_form($form, &$form_state) {
  $form = array(
    'simplerecipe_mail' => array(
      '#type' => 'textfield',
      '#title' => t('E-mail address'),
      '#default_value' => variable_get('simplerecipe_mail'),
    ),
  );
  
  $form['multilanguage'] = array(
    '#type' => 'fieldset',
    '#title' => t('Enable/ÏDisable seperate e-mail addresses per language'),
    'link' => array(
      '#markup' => l(t('Download %module', array('%module' => t('Variable translation'))), 'http://drupal.org/project/i18n', array('html' => TRUE)),
      '#prefix' => '<p>',
      '#suffix' => '</p>',
    )
  );
  
  if (module_exists('i18n_variable')) {
    $form['multilanguage']['link'] = array(
      '#markup' => l(t('Variable translation'), 'admin/config/regional/i18n/variable', array('query'=>  drupal_get_destination())),
    );
  }
  return system_settings_form($form);
}

function recipe_settings_form_validate($form, &$form_state) {
  if (!valid_email_address($form_state['values']['simplerecipe_mail'])) {
    form_set_error('simplerecipe_mail', t('Provide a valid e-mail address'));
  }
}
