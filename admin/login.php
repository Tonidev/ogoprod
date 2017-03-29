<?php
$login = empty($_REQUEST['login']) ? '' : $_REQUEST['login'];
$pass = empty($_REQUEST['pass']) ? '' : $_REQUEST['pass'];
$remember = empty($_REQUEST['remember']) ? false : true;
if(!empty($login) && !empty($pass)) {
  $login_error = login($login, $pass, $remember);
}
?>

<form class="form-signin" action="/admin/login" method="post">
  <h2 class="form-signin-heading">Вход</h2>
  <? if(!empty($login_error) ) { ?>
      <div class="alert alert-danger"><?= $login_error ?></div>
  <? } ?>
  <label for="login" class="sr-only">Логин</label>
  <input
      type="text"
      name="login"
      class="form-control"
      placeholder="Логин"
      required="" autofocus=""
      value="<?= $login ?>">

  <label for="inputPassword" class="sr-only">Пароль</label>
  <input
      type="password"
      name="pass"
      class="form-control"
      placeholder="Пароль"
      required=""
      value="<?= $pass ?>">

  <div class="checkbox">
    <label>
      <input
          type="checkbox"
          name="remember"
          <?= $remember ?'checked="checked"' : '' ?>
          value="remember-me">
      Запомнить меня
    </label>
  </div>

  <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
</form>
