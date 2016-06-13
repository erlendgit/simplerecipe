<?php

namespace Drupal\simplerecipe;

class Stub {

  protected static $instance;

  /**
   * 
   * @return Stub
   */
  public static function f() {
    if (!(static::$instance instanceof Stub)) {
      throw new \Exception(t("initialize stub first"));
    }
    return static::$instance;
  }
  
  public static function initStub() {
    static::attach(new Stub());
  }

  public static function attach(Stub $instance) {
    static::$instance = $instance;
  }

  public function t($string, $args = array(), $options = array()) {
    return t($string, $args, $options);
  }

  public function valid_email_address($mail) {
    return valid_email_address($mail);
  }

  public function current_language() {
    global $language;
    return $language->language;
  }

}
