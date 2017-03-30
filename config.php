<?php
session_start();
require_once (BASE_DIR .'safemysql.class.php');


class Config {

  static $db_connection_string = array('user' => 'root', 'pass' => 'kane-ga', 'db' => 'ogoprod');
  public static $ADMIN_SHORT_SESSION_TIME = 60*15; //15 min
  public static $ADMIN_SESSION_TIME = 60*60*24*7; //1 week
  public static $siteName = 'OGO Production';

  public static $SERVICE_POSITION = 0;
  public static $SOURCE_POSITION = 1;

  public static $PROMO_SERVICES = array (
      'D' => array(
          'name' => 'Фотосессия',
          'discount' => 'Скидка по промокоду 15%'
          ),
      'Y' => array(
          'name' => 'Фотошкола',
          'discount' => 'Скидка по промокоду 25%'
      )
  );
  public static $PROMO_SOURCES = array(
      'K' => 'Vk',
      'X' => 'Instagram',
      'G' => 'Geometria',
      'F' => 'Миталлстилл',
  );

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

include ('constants.php');


class Helpers {

  public static function jsonAnswer($status, $msg, $data = null, $echo = true, $htmlentities = true)
  {
    $statusTxt = $status ? 'ok' : 'error';
    $text = $msg;
    if($htmlentities) {
      $msg = htmlentities($msg);
    }
    $msg = $status ? $msg : '<div class="alert alert-warning">' . $msg . '</div>';
    $resp = array(
        'status' => $statusTxt,
        'success' => $status,
        'text' => $text,
        'msg' => $msg
    );

    if(!empty($data)) {
      $resp['data'] = $data;
    }
    $data = json_encode($resp);
    if($echo) {
      echo $data;
    }
    return $data;
  }

  public static function jsonOk($msg = 'OK', $data = null, $echo = true, $htmlentities = true) {
    return self::jsonAnswer(1, $msg, $data, $echo, $htmlentities);
  }

  public static function jsonError($msg = 'error', $data = null, $echo = true,  $htmlentities = true) {
    return self::jsonAnswer(0, $msg, $data, $echo, $htmlentities);
  }

  public static function redirect($url, $code = 301, $replace = true)
  {
    header("Location : $url", $replace, $code);
    die;
  }

  public static function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
      $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
      $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
      $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
      $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
      $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
      $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
      $ipaddress = 'UNKNOWN';
    return $ipaddress;
  }

}
