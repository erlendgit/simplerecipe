<?php

use Drupal\simplerecipe\Recipe\Recipe;
use Drupal\simplerecipe\Recipe\Exception as ValidationException;
use Drupal\simplerecipe\Stub;

function recipe_add_form($form, &$form_state) {

  $form = array(
    'recipe' => array(
      '#type' => 'fieldset',
      '#title' => t('Enter recipe details'),
      'title' => array(
        '#type' => 'textfield',
        '#title' => t('Title'),
        '#required' => TRUE,
      ),
      'title' => array(
        '#type' => 'textfield',
        '#title' => t('Title'),
        '#required' => TRUE,
      ),
      'author_name' => array(
        '#type' => 'textfield',
        '#title' => t('Your name'),
        '#required' => TRUE,
      ),
      'author_mail' => array(
        '#type' => 'textfield',
        '#title' => t('Your e-mail address'),
        '#required' => TRUE,
      ),
      'recipe_description' => array(
        '#type' => 'textarea',
        '#rows' => 4,
        '#title' => t('Description'),
        '#description' => t('Enter a short description for the recipe. Use at most 500 characters.'),
        '#required' => TRUE,
      ),
      'recipe_instructions' => array(
        '#type' => 'textarea',
        '#rows' => 8,
        '#title' => t('Instructions'),
        '#description' => t('Explain how to prepare this recipe.'),
        '#required' => TRUE,
      ),
      'recipe_ingredients' => array(
        '#type' => 'textarea',
        '#rows' => 8,
        '#title' => t('Ingredients'),
        '#description' => t('List all required ingredients.'),
        '#required' => TRUE,
      ),
    ),
    'actions' => array(
      '#type' => 'actions',
      'submit' => array(
        '#type' => 'submit',
        '#value' => t('Submit recipe'),
      ),
    )
  );

  return $form;
}

function recipe_add_form_validate($form, &$form_state) {
  $recipe = new Recipe();
  $form_state['recipe'] = NULL;

  try {
    $recipe->setTitle($form_state['values']['title']);
    $recipe->setAuthorName($form_state['values']['author_name']);
    $recipe->setAuthorMail($form_state['values']['author_mail']);
    $recipe->setRecipeDescription($form_state['values']['recipe_description']);
    $recipe->setRecipeInstructions($form_state['values']['recipe_instructions']);
    $recipe->setRecipeIngredients($form_state['values']['recipe_ingredients']);
    $recipe->setLangcode(Stub::f()->current_language());

    $form_state['recipe'] = $recipe;
  } catch (ValidationException $ex) {
    form_set_error($ex->getField(), $ex->getMessage());
  }
}

function recipe_add_form_submit($form, &$form_state) {
  try {
    if (empty($form_state['recipe']) || !($form_state['recipe'] instanceof Recipe)) {
      throw new Exception(t("Recipe validation failed"));
    }
    $recipe = $form_state['recipe'];
    
    $recipe->insert();
    
    drupal_set_message(t("Thanks for your succesfull recipe submission!"));
    $form_state['redirect'] = '<front>';
    
    // send mail if required
    $to = variable_get('simplerecipe_mail');
    if (valid_email_address($to)) {
      drupal_mail('simplerecipe', 'new_recipe', $to, NULL, array('recipe' => $recipe));
    }
    
  } catch (Exception $ex) {
    drupal_set_message($ex->getMessage(), 'error', FALSE);
    $form_state['rebuild'] = TRUE;
  }
}
