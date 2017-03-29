<?php
/**
 * Created by PhpStorm.
 * User: shikon
 * Date: 29.03.17
 * Time: 6:09
 */

if(!defined('BASE_DIR')) {
  define('BASE_DIR', __DIR__ .DIRECTORY_SEPARATOR);
}

if(!defined('ADMIN_DIR')) {
  define('ADMIN_DIR', __DIR__ .DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR);
}
require_once(BASE_DIR . 'config.php');

require_once (ADMIN_DIR . 'func.php');

$action = empty($_REQUEST['action']) ? 'index' : $_REQUEST['action'];
switch ($action) {
  case 'header':
  case 'footer':
  case 'layout':
  case 'func':
    $action = 'index';
    break;
  case 'logout' :
    logout();
    break;
}

$login = check_admin_granted();
if(!$login && $action != 'login') {
  redirect('/admin/login');
} elseif ($login && $action == 'login') {
  $action = 'index';
}



//if(!is_dir(ADMIN_DIR)) {
//  mkdir(ADMIN_DIR);
//}


if(!defined('ADMIN_LAYOUT_FILE')) {
  define('ADMIN_LAYOUT_FILE', ADMIN_DIR . 'layout.php');
}

$action_file = ADMIN_DIR . $action . '.php';

if(file_exists($action_file)) {
  $no_layout = false;
  ob_start();
  include($action_file);
  $admin_content = ob_get_contents();
  ob_end_clean();
  if($no_layout) {
    echo $admin_content;
  } else {
    include (ADMIN_DIR . 'layout.php');
  }
}


