<?php
/**
 * Created by PhpStorm.
 * User: shikon
 * Date: 04.04.17
 * Time: 6:59
 */

$func = empty($_REQUEST['func']) ? null : $_REQUEST['func'];
if (!empty($func)) {
  if(!empty($_REQUEST['ajax'])) {
    switch ($func) {
      case 'add' :
        $name = empty($_REQUEST['name']) ? '' :  $_REQUEST['name'];
        if (empty($name)) {
          Helpers::jsonError('Не вказано назви альбому');
          break;
        }
        $existing = Db::i()->getOne("SELECT name FROM album WHERE name = ?s", $name);
        if(!empty($existing)) {
          Helpers::jsonError('Альбом з такою назвою вже існує');
          die();
        }
        $descr = empty($_REQUEST['description']) ? '' : $_REQUEST['description'];
        $status = empty($_REQUEST['status']) ? 0 : intval($_REQUEST['status']);
        $result = Db::i()->query("INSERT INTO album (name, description, status) VALUES (?s, ?s, ?i)", $name, $descr, $status);
        if ($result) {
          $aid = Db::i()->insertId();
          $album = array(
              'id' => $aid,
              'name' => $name,
              'description' => $descr,
              'status' => $status,
              'count' => 0,
              'date' => date('d/m/Y')
          );
          Helpers::jsonOk("Альбом успішно створено",$album);
        } else {
          Helpers::jsonError("Помилка створення альбому");
        }
        break;
      case 'edit' :
        $id = empty($_REQUEST['id']) ? null : $_REQUEST['id'];
        if(empty($id)) {
          Helpers::jsonError('Не вказаний альбом');
          die();
        }
        $name = empty($_REQUEST['name']) ? '' :  $_REQUEST['name'];
        if (empty($name)) {
          Helpers::jsonError('Не вказано назви альбому');
          break;
        }
        $existing = Db::i()->getOne("SELECT name FROM album WHERE name = ?s AND id != ?i", $name, $id);
        if(!empty($existing)) {
          Helpers::jsonError('Альбом з такою назвою вже існує');
          die();
        }
        $descr = empty($_REQUEST['description']) ? '' : $_REQUEST['description'];
        $status = empty($_REQUEST['status']) ? 0 : intval($_REQUEST['status']);
        $result = Db::i()->query("UPDATE album SET name = ?s, description = ?s, status =?i WHERE id = ?i", $name, $descr, $status, $id);
        if ($result) {
          $album = array(
              'id' => $id,
              'name' => $name,
              'description' => $descr,
              'status' => $status,
              'count' => 0,
              'date' => date('d/m/Y')
          );
          Helpers::jsonOk("Альбом успішно оновлено",$album);
        } else {
          Helpers::jsonError("Помилка оновлення альбому");
        }
        break;
    }
    die();
  }
}


$albums = Db::i()->getAll("
  SELECT a.* , COUNT(p.id) as `count`
FROM album a 
LEFT JOIN photo p 
  ON p.id_album = a.id
  AND p.status > 0
GROUP BY a.id
  ");
?>
<h1>Список альбомів</h1>

<div class="clearfix">
  <div class="panel panel-default col-lg-3 col-md-6 col-xs-12 albums-form">
    <div class="panel-heading toggle_next row">
      <h4>Додати новий</h4>
      <label class="badge hidden"><?= date('d/m/Y') ?></label>
      <div class="pull-right hidden"><label class="badge">0</label> Фото</div>
    </div>
    <div class="panel-body row loose-hidden">
      <form method="post">
        <input type="hidden" name="func" value="add">
        <input type="hidden" name="id" value="">
        <input type="hidden" name="ajax" value="ajax">
        <div>
          <input class="form-control" required="required" name="name" placeholder="Назва альбому">
          <textarea class="form-control" name="description" placeholder="Описання альбому"></textarea>
          <select class="form-control" name="status">
            <option value="1">Опублікований</option>
            <option value="0">Не опублікований</option>
          </select>
          <button class="btn-default btn add">Додати</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="clearfix album-list-panel">
  <? foreach( $albums as $album) { ?>
    <div class="panel panel-default col-lg-3 col-md-6 col-xs-12 albums-form" data-id="<?= $album['id'] ?>">
      <div class="panel-heading row toggle_next">
        <label class="badge"><?= date('d/m/Y', strtotime($album['date']) ) ?></label>
        <span class="panel-title"><?= $album['name'] ?></span>
        <div class="pull-right"><label class="badge"><?= $album['count'] ?></label> Фото</div>
      </div>
      <div class="panel-body row loose-hidden">
        <form method="post">
          <input type="hidden" name="func" value="edit">
          <input type="hidden" name="id" value="<?= $album['id'] ?>">
          <div>
            <input class="form-control" required="required" name="name" value="<?= $album['name'] ?>">
            <textarea class="form-control" name="description"><?= $album['description'] ?></textarea>
            <select class="form-control" name="status">
              <option value="1" <?= empty($album['status'])? '' : 'selected' ?> >
                Опублікований
              </option>
              <option value="0"  <?= !empty($album['status'])? '' : 'selected' ?> >
                Не опублікований
              </option>
            </select>
            <button class="btn-default btn">Зберегти</button>
          </div>
        </form>
      </div>
    </div>
  <? } ?>
</div>
