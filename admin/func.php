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
    $_SESSION['login'] = $login;
  }

  redirect('/admin');
  return '';
}

function check_admin_granted() {
  $sid = session_id();
  if(
      empty($sid) ||
      empty($_SESSION['login']) ||
      empty($_SESSION['admin_granted']) ||
      time() > $_SESSION['admin_granted']
  ) {
    return false;
  }
  $_SESSION['admin_granted'] = time() + ADMIN_SHORT_SESSION_TIME;
  return $_SESSION['login'];
}

function redirect($url, $code = 301, $replace = true) {
  Helpers::redirect($url, $code, $replace);
}


function logout() {
  $sid = session_id();
  if(
      empty($sid)
  ) {
    return false;
  }
  unset($_SESSION['login']);
  unset($_SESSION['admin_granted']);
  redirect('/admin');
}
