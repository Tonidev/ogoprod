<?php
/**
 * Created by PhpStorm.
 * User: shikon
 * Date: 29.03.17
 * Time: 6:49
 */
/** @var string $action */
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><?= Config::$siteName; ?></a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <? if(empty($login)) { ?>
          <li><a href="/admin/login">Войти</a></li>
        <? } ?>
        <li><a href="#"><?= $login ?></a></li>
        <li><a href="/admin/logout">Выйти</a></li>
      </ul>
      <? if(false) { ?>
        <form class="navbar-form navbar-right">
          <input type="text" class="form-control" placeholder="Search...">
        </form>
      <? } ?>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-3 col-md-2 col-lg-1 sidebar">
      <ul class="nav nav-sidebar">
        <li <?= $action=='index' ? ' class="active" ': '' ?>>
          <a href="/admin">Промо</a></li>

        <li <?= $action=='photo' ? ' class="active" ': '' ?>>
          <a href="/admin/photo">Залити фото</a></li>

        <li <?= $action=='photos' ? ' class="active" ': '' ?>>
          <a href="/admin/photos">Фото</a></li>

        <li <?= $action=='albums' ? ' class="active" ': '' ?>>
        <a href="/admin/albums">Альбоми</a></li>

      </ul>
    </div>

