<?php if (!empty($recipe->id)) : ?>
  <div class="recipe">
      <ul class="recipe--details">
          <li class="recipe--details recipe--language">
              <span class="label"><?php print t('Language'); ?>: </span>
              <span class="data"><?php print $language->native; ?> (<?php print $language->name; ?>)</span>
          </li>
          <li class="recipe--details recipe--created">
              <span class="label"><?php print t('Created'); ?>: </span>
              <span class="data"><?php print $created; ?></span>
          </li>
          <li class="recipe--details recipe--author-name">
              <span class="label"><?php print t('Author name'); ?>: </span>
              <span class="data"><?php print $author_name; ?></span>
          </li>
          <li class="recipe--details recipe--author-mail">
              <span class="label"><?php print t('Author e-mail'); ?>: </span>
              <span class="data"><?php print $author_mail; ?></span>
          </li>
          <li class="recipe--details recipe--recipe-description">
              <span class="label"><?php print t('Description'); ?>: </span>
              <span class="data"><?php print $recipe_description; ?></span>
          </li>
          <li class="recipe--details recipe--recipe-instructions">
              <span class="label"><?php print t('Instructions'); ?>: </span>
              <span class="data"><?php print $recipe_instructions; ?></span>
          </li>
          <li class="recipe--details recipe--recipe-ingredients">
              <span class="label"><?php print t('Ingredients'); ?>: </span>
              <span class="data"><?php print $recipe_ingredients; ?></span>
          </li>
      </ul>
  </div>
<?php endif; ?>