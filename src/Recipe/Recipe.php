<?php

namespace Drupal\simplerecipe\Recipe;

use Drupal\simplerecipe\Recipe\Exception;
use Drupal\simplerecipe\Connector\Connector;
use Drupal\simplerecipe\Stub;

class Recipe {

  const VARCHAR_MINLEN = 1;
  const VARCHAR_MAXLEN = 255;
  const TEXT_MINLEN = 1;
  const TEXT_MAXLEN = 500;

  protected $data;
  protected $validate_field;

  public function __construct($data = array()) {
    $this->data = $data;
  }

  public static function load($id) {
    global $simplerecipe_cache;

    if (empty($simplerecipe_cache[$id]['isset'])) {
      $simplerecipe_cache[$id] = array(
        'isset' => TRUE,
        'data' => NULL,
      );
      $data = Connector::c()->load(array('id' => $id));
      if ($data) {
        $simplerecipe_cache[$id]['data'] = new Recipe(reset($data));
      }
    }
    return $simplerecipe_cache[$id]['data'];
  }

  public function insert() {
    $this->data['created'] = time();
    $this->setId(Connector::c()->insert($this->data));
  }

  public function __get($name) {
    if (!array_key_exists($name, $this->data)) {
      return;
    }
    return $this->data[$name];
  }

  public function __isset($name) {
    if (array_key_exists($name, $this->data)) {
      return TRUE;
    }
    return FALSE;
  }

  public function setTitle($title) {
    $this->validateTitle($title);
    $this->data['title'] = $title;
  }

  public function validateTitle($title) {
    $this->validate_field = 'title';
    $this->hasEnoughCharacters($title, self::VARCHAR_MINLEN, Stub::f()->t("Title is manditory"));
    $this->hasTooMuchCharacters($title, self::VARCHAR_MAXLEN, Stub::f()->t("Title is too long"));
  }

  public function setAuthorName($author) {
    $this->validateAuthorName($author);
    $this->data['author_name'] = $author;
  }

  public function validateAuthorName($author) {
    $this->validate_field = 'author_name';
    $this->hasEnoughCharacters($author, self::VARCHAR_MINLEN, Stub::f()->t("Author name is manditory"));
    $this->hasTooMuchCharacters($author, self::VARCHAR_MAXLEN, Stub::f()->t("Author name consist of to many characters"));
  }

  public function setAuthorMail($mail) {
    $this->validateAuthorMail($mail);
    $this->data['author_mail'] = $mail;
  }

  public function validateAuthorMail($mail) {
    $this->validate_field = 'author_mail';
    $this->hasEnoughCharacters($mail, self::VARCHAR_MINLEN, Stub::f()->t("Author mail is manditory"));
    $this->hasTooMuchCharacters($mail, self::VARCHAR_MAXLEN, Stub::f()->t("Author mail consist of to many characters"));
    $this->isValidMail($mail, Stub::f()->t("Author mail is not a valid e-mail address"));
  }

  public function setRecipeDescription($description) {
    $this->validateDescription($description);
    $this->data['recipe_description'] = $description;
  }

  public function validateDescription($description) {
    $this->validate_field = 'recipe_description';
    $this->hasEnoughCharacters($description, self::TEXT_MINLEN, Stub::f()->t("Recipe description is manditory"));
    $this->hasTooMuchCharacters($description, self::TEXT_MAXLEN, Stub::f()->t("Recipe description consist of to many characters"));
  }

  public function setRecipeInstructions($instructions) {
    $this->data['recipe_instructions'] = $instructions;
  }

  public function setRecipeIngredients($ingredients) {
    $this->data['recipe_ingredients'] = $ingredients;
  }

  public function setId($id) {
    $this->validateId($id);
    $this->data['id'] = $id;
  }

  public function validateId($id) {
    $this->validate_field = 'id';
    $this->isInteger($id, Stub::f()->t("ID must be an integer"));
  }

  public function setLangcode($code) {
    $this->validateLangcode($code);
    $this->data['langcode'] = $code;
  }

  public function validateLangcode($code) {
    $this->validate_field = 'langcode';
    $this->isISO2Langcode($code, Stub::f()->t("Langcode must be ISO-2 complient"));
  }

  public function isISO2Langcode($code, $message) {
    if (!preg_match('/^[a-z][a-z]$/', $code)) {
      throw new Exception($message, $this->validate_field);
    }
  }

  public function isInteger($id, $message) {
    if (!preg_match('/^[0-9]+$/', $id)) {
      throw new Exception($message, $this->validate_field);
    }
  }

  public function hasEnoughCharacters($test, $threshold, $message) {
    if (strlen($test) < $threshold) {
      throw new Exception($message, $this->validate_field);
    }
  }

  public function hasTooMuchCharacters($test, $threshold, $message) {
    if (strlen($test) > $threshold) {
      throw new Exception($message, $this->validate_field);
    }
  }

  public function isValidMail($mail, $message) {
    if (!Stub::f()->valid_email_address($mail)) {
      throw new Exception($message, $this->validate_field);
    }
  }

}
