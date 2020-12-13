<?php
class Conf {
   
  private static $debug = false;

  static private $databases = array(
    'hostname' => 'webinfo.iutmontp.univ-montp2.fr',
    'database' => 'michelm',
    'login' => 'michelm',
    'password' => 'password'
  );

   
  static public function getGen($var) {
    return self::$databases[$var];
  }

  static public function getDebug() {
      return self::$debug;
  }
}

