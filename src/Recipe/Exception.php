<?php

namespace Drupal\simplerecipe\Recipe;

class Exception extends \Exception {

  protected $field;

  public function __construct($message, $field = '') {
    parent::__construct($message);
    $this->field = $field;
  }

  public function getField() {
    return $this->field;
  }

}
