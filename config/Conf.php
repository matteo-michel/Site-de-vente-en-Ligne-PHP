<?php
class Conf {
   
  private static $debug = false;

  static private $databases = array(
    'hostname' => '',
    'database' => '',
    'login' => '',
    'password' => ''
  );

   
  static public function getGen($var) {
    return self::$databases[$var];
  }

  static public function getDebug() {
      return self::$debug;
  }
}

