<?php

use Drupal\simplerecipe\Recipe\Recipe;

function simplerecipe_mail_new_recipe(&$message, $params) {
  $recipe = $params['recipe'];

  if ($recipe instanceof Recipe && !empty($recipe->id)) {
    $translation_options = array('langcode' => $recipe->langcode);

    $recipe_url = recipe_item_url($recipe, array('absolute' => TRUE));
    $message['subject'] = t("New recipe");
    $message['body'] = t('Read the new recipe at !url.', array('!url' => $recipe_url), $translation_options);
  } else {
    // no recipe? no mail.
    $message['send'] = FALSE;
  }
}
