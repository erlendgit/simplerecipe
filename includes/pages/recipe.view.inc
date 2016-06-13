<?php

use Drupal\simplerecipe\Recipe\Recipe;

function recipe_view($recipe) {

  if ($recipe instanceof Recipe) {

    drupal_set_title($recipe->title);

    return theme('recipe', array(
      'recipe' => $recipe,
    ));
  }
  drupal_not_found();
  drupal_exit();
}
