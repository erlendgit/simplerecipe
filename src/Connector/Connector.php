<?php

namespace Drupal\simplerecipe\Connector;

use Exception;
use PDO;

class Connector {

  protected static $instance;

  /**
   * 
   * @return Connector
   */
  public static function c() {
    if (!(self::$instance instanceof Connector)) {
      self::$instance = new Connector();
    }
    return self::$instance;
  }

  public static function attach(Connector $conn) {
    self::$instance = $conn;
  }

  public function load($conditions = array()) {
    try {
      $query = db_select('simplerecipe_recipes', 'r');
      $query->fields('r');
      foreach ($conditions as $field => $value) {
        $query->condition($field, $value);
      }
      $result = $query->execute();
      $result->setFetchMode(PDO::FETCH_ASSOC);
      $records = $result->fetchAllAssoc('id');
      return $records;
    } catch (Exception $ex) {
      throw new Exception(t("Error while looking for recipe(s) in the database"));
    }
  }

  public function insert($data = array()) {
    try {
      $query = db_insert('simplerecipe_recipes')->fields($data);
      return $query->execute();
    } catch (Exception $ex) {
      throw new Exception(t("Error while storing the recipe to the database"));
    }
  }

}
