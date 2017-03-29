<?php


function login($login, $pass, $remember_me = false) {
  $result = Db::i()->getRow("SELECT * FROM admin WHERE login = ?s AND pass = ?s", $login, md5($login.$pass));
  if(empty($result)) {
    return "Неправильные данные";
  }
  $sid = session_id();
  if(!empty($sid)) {
    if($remember_me ) {
      $_SESSION['admin_granted'] = time() + ADMIN_SESSION_TIME ;
    } else {
      $_SESSION['admin_granted'] = time() + ADMIN_SHORT_SESSION_TIME;
    }
  }

  redirect('/admin');
  return '';
}

function check_admin_granted() {
  $sid = session_id();
  if(
      empty($sid) ||
      empty($_SESSION['admin_granted']) ||
      time() > $_SESSION['admin_granted']
  ) {
    return false;
  }
  $_SESSION['admin_granted'] = time() + ADMIN_SHORT_SESSION_TIME;

  return true;
}

function redirect($url, $code = 301, $replace = true) {
  header("Location : $url", $replace, $code);
  die;
}
