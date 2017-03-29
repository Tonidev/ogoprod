<?php
session_start();
require_once (BASE_DIR .'safemysql.class.php');


class Config {

  static $db_connection_string = array('user' => 'root', 'pass' => 'kane-ga', 'db' => 'ogoprod');
  public static $ADMIN_SHORT_SESSION_TIME = 60*15; //15 min
  public static $ADMIN_SESSION_TIME = 60*60*24*7; //1 week
  public static $siteName = 'OGO Production';
}


/**
 * Class Db
 * @static SafeMySQL $db
 */
class Db {
  public static $db;
  static function init(){
    self::$db = new SafeMySQL(Config::$db_connection_string);
  }

  /**
   * @return SafeMySQL
   */
  public static function i() {
    return self::$db;
  }
}

Db::init();

if (!defined('ADMIN_SHORT_SESSION_TIME')) {
  define('ADMIN_SHORT_SESSION_TIME', Config::$ADMIN_SHORT_SESSION_TIME);
}
if (!defined('ADMIN_SESSION_TIME')) {
  define('ADMIN_SESSION_TIME', Config::$ADMIN_SESSION_TIME);
}
