<?php

namespace Drupal\simplerecipe\tests\TestDoubles;

use Drupal\simplerecipe\Stub as BaseStub;

class Stub extends BaseStub {

  public static function initStub() {
    BaseStub::attach(new Stub());
  }

  public function t($string, $args = array(), $options = array()) {
    return $string;
  }
  
  public function valid_email_address($mail) {
    return TRUE; // be gracefull most of the time
  }
  
  public function current_language() {
    return "en";
  }
  
}
