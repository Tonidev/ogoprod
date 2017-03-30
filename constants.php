<?php

if(!defined('BASE_DIR')) {
  define('BASE_DIR', __DIR__ .DIRECTORY_SEPARATOR);
}

if (!defined('BASE_URL')) {
  define('BASE_URL', '/');
}

if (!defined('ADMIN_SHORT_SESSION_TIME')) {
  define('ADMIN_SHORT_SESSION_TIME', Config::$ADMIN_SHORT_SESSION_TIME);
}
if (!defined('ADMIN_SESSION_TIME')) {
  define('ADMIN_SESSION_TIME', Config::$ADMIN_SESSION_TIME);
}
if (!defined('BASE_PHOTO_PATH')) {
  define('BASE_PHOTO_PATH', BASE_DIR . 'photo' . DIRECTORY_SEPARATOR);
}
if (!defined('BASE_PHOTO_URL')) {
  define('BASE_PHOTO_URL', BASE_URL . 'photo/');
}
