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
        $chpu = empty($_REQUEST['chpu']) ? '' :  $_REQUEST['chpu'];
        if (empty($chpu)) {
          Helpers::jsonError('Не вказано URL альбому');
          break;
        }
        $existing = Db::i()->getOne("SELECT name FROM album WHERE name LIKE ?s", $name);
        if(!empty($existing)) {
          Helpers::jsonError('Альбом з такою назвою вже існує');
          break;
        }
        $existing = Db::i()->getOne("SELECT chpu FROM album WHERE chpu LIKE ?s", $chpu);
        if(!empty($existing)) {
          Helpers::jsonError('Альбом з таким URL вже існує');
          break;
        }
        $descr = empty($_REQUEST['description']) ? '' : $_REQUEST['description'];
        $status = empty($_REQUEST['status']) ? 0 : intval($_REQUEST['status']);
        $result = Db::i()->query("INSERT INTO album (name, description, status, chpu) VALUES (?s, ?s, ?i, ?s)", $name, $descr, $status, $chpu);
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
        $chpu = empty($_REQUEST['chpu']) ? '' :  $_REQUEST['chpu'];
        if (empty($chpu)) {
          Helpers::jsonError('Не вказано URL альбому');
          break;
        }
        $existing = Db::i()->getOne("SELECT name FROM album WHERE name LIKE ?s AND id != ?i", $name, $id);
        if(!empty($existing)) {
          Helpers::jsonError('Альбом з такою назвою вже існує');
          die();
        }
        $existing = Db::i()->getOne("SELECT chpu FROM album WHERE chpu LIKE ?s AND id != ?i", $chpu, $id);
        if(!empty($existing)) {
          Helpers::jsonError('Альбом з таким URL вже існує');
          die();
        }
        $descr = empty($_REQUEST['description']) ? '' : $_REQUEST['description'];
        $status = empty($_REQUEST['status']) ? 0 : intval($_REQUEST['status']);
        $date = empty($_REQUEST['date']) ? date('Y-m-d') : $_REQUEST['date'];
        $result = Db::i()->query("UPDATE album SET name = ?s, description = ?s, status =?i , `date` = ?s , `chpu` =?s WHERE id = ?i", $name, $descr, $status, $date, $chpu, $id);
        if ($result) {
          $album = array(
              'id' => $id,
              'name' => $name,
              'chpu' => $chpu,
              'description' => $descr,
              'status' => $status,
              'count' => 0,
              'date' => date('d/m/Y', strtotime($date))
          );
          Helpers::jsonOk("Альбом успішно оновлено",$album);
        } else {
          Helpers::jsonError("Помилка оновлення альбому");
        }
        break;
      case 'delete' :
        $id = empty($_REQUEST['id']) ? null : $_REQUEST['id'];
        if(empty($id)) {
          Helpers::jsonError('Не вказаний альбом');
          die();
        }
        $photos = Db::i()->getAll("SELECT * FROM photo WHERE id_album = ?i", $id);
        $file_counter = 0;
        foreach ($photos as $photo) {
          if(file_exists(BASE_DIR . $photo['url'])) {
            unlink(BASE_DIR . $photo['url']);
            $file_counter++;
          }
          if(file_exists(BASE_DIR . $photo['url_mini'])) {
            unlink(BASE_DIR . $photo['url_mini']);
            $file_counter++;
          }
        }
        Db::i()->query("DELETE FROM photo WHERE id_album = ?i", $id);
        Db::i()->query("DELETE FROM album WHERE id = ?i", $id);
        Helpers::jsonOk("Альбом видалено", array('id' => $id));
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
      <label class="badge date hidden"><?= date('d/m/Y') ?></label>
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
            <option value="<?= Config::$ALBUM_STATUS_PUBLISHED ?>" >
              Опублікований
            </option>
            <option value="<?= Config::$ALBUM_STATUS_DISABLED ?>"  >
              Не опублікований
            </option>
            <option value="<?= Config::$ALBUM_STATUS_PORTFOLIO_VADIM ?>" >
              Портфоліо Вадима
            </option>
            <option value="<?= Config::$ALBUM_STATUS_PORTFOLIO_ARCHIL ?>"  >
              Портфоліо Арчіла
            </option>
            <option value="<?= Config::$ALBUM_STATUS_BLOG?>"  >
              Блог
            </option>
          </select>
          <input class="form-control" name="chpu" placeholder="URL">
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
        <label class="badge date"><?= date('d/m/Y', strtotime($album['date']) ) ?></label>
        <span class="panel-title"><?= $album['name'] ?></span>
        <div class="pull-right"><label class="badge"><?= $album['count'] ?></label> Фото</div>
      </div>
      <div class="panel-body row loose-hidden">
        <form method="post">
          <input type="hidden" name="id" value="<?= $album['id'] ?>">
          <div>
            <input class="form-control" required="required" name="name" placeholder="Назва" value="<?= $album['name'] ?>">
            <textarea class="form-control" name="description" placeholder="Опис"><?= $album['description'] ?></textarea>
            <select class="form-control" name="status">
              <option value="<?= Config::$ALBUM_STATUS_DISABLED ?>"  <?= ($album['status'] == Config::$ALBUM_STATUS_DISABLED) ? 'selected' : '' ?> >
                Не опублікований
              </option>
              <option value="<?= Config::$ALBUM_STATUS_PUBLISHED ?>" <?= ($album['status'] == Config::$ALBUM_STATUS_PUBLISHED) ? 'selected' : '' ?> >
                Опублікований
              </option>
              <option value="<?= Config::$ALBUM_STATUS_PORTFOLIO_VADIM ?>"  <?= ($album['status'] == Config::$ALBUM_STATUS_PORTFOLIO_VADIM) ? 'selected' : '' ?> >
                Портфоліо Вадима
              </option>
              <option value="<?= Config::$ALBUM_STATUS_PORTFOLIO_ARCHIL ?>"  <?= ($album['status'] == Config::$ALBUM_STATUS_PORTFOLIO_ARCHIL) ? 'selected' : '' ?> >
                Портфоліо Арчіла
              </option>
              <option value="<?= Config::$ALBUM_STATUS_BLOG ?>"  <?= ($album['status'] == Config::$ALBUM_STATUS_BLOG) ? 'selected' : '' ?> >
                Блог
              </option>
            </select>
            <input  class="form-control" type="date" name="date" value="<?= date('Y-m-d', strtotime($album['date'])) ?>">
            <input class="form-control" name="chpu" placeholder="URL" value="<?= $album['chpu'] ?>" >

            <button class="btn-default btn" name="func" value="edit">Зберегти</button>
            <a href="/admin/photos?id_album=<?= $album['id'] ?>" class="btn-default btn">Відкрити альбом</a>
            <button class="btn-default btn pull-right" name="func" value="delete">Видалити</button>
          </div>
        </form>
      </div>
    </div>
  <? } ?>
</div>
