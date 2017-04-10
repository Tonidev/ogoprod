<?php

$ida = !isset($_REQUEST['id_album']) ? null : intval($_REQUEST['id_album']);
$id = empty($_REQUEST['id']) ? null : intval($_REQUEST['id']);

$func = empty($_REQUEST['func']) ? null : $_REQUEST['func'];
if (!empty($func)) {
  if(!empty($_REQUEST['ajax'])) {
    switch ($func) {
      case 'edit' :
        $id = empty($_REQUEST['id']) ? null : $_REQUEST['id'];
        if(empty($id)) {
          Helpers::jsonError('Не вказане фото');
          die();
        }
        $descr = empty($_REQUEST['description']) ? '' : $_REQUEST['description'];
        $status = empty($_REQUEST['status']) ? 0 : intval($_REQUEST['status']);
        $id_album = empty($_REQUEST['id_album']) ? 0 : intval($_REQUEST['id_album']);
        $result = Db::i()->query("
UPDATE photo 
SET description = ?s, id_album = ?i,  `status` =?i 
WHERE id = ?i", $descr, $id_album, $status, $id);
        if ($result) {
          Helpers::jsonOk("Фото успішно оновлено");
        } else {
          Helpers::jsonError("Помилка оновлення фото");
        }
        break;
      case 'delete' :
        $id = empty($_REQUEST['id']) ? null : $_REQUEST['id'];
        if(empty($id)) {
          Helpers::jsonError('Не вказане фото');
          die();
        }
        $photo = Db::i()->getRow("SELECT * FROM photo WHERE id = ?i", $id);
        if(empty($photo)) {
          Helpers::jsonError('Фото не знайдене');
          die();
        }
        $file_counter = 0;
        if(file_exists(BASE_DIR . $photo['url'])) {
          unlink(BASE_DIR . $photo['url']);
          $file_counter++;
        }
        if(file_exists(BASE_DIR . $photo['url_mini'])) {
          unlink(BASE_DIR . $photo['url_mini']);
          $file_counter++;
        }
        Db::i()->query("DELETE FROM photo WHERE id = ?i", $id);

        Helpers::jsonOk("Фото видалено", array('id' => $id));
        break;
      case 'updatePositions':
        $indexes = empty($_REQUEST['indexes']) ? null : $_REQUEST['indexes'];
        if(empty($indexes)) {
          Helpers::jsonError("Позиції не були передані");
        } else {
          foreach ($indexes as $index) {
            Db::i()->query("UPDATE photo SET position = ?i WHERE id = ?i", $index['position'], $index['id']);
          }
          Helpers::jsonOk();
        }
        break;
      default :
        Helpers::jsonError("Невідома функція");
    }
    die();
  }
}

$ida_and = '';
if(is_numeric($ida)) {
  $ida_and = " AND p.id_album = $ida";
}

$idp_and = '';
$idp = empty($_REQUEST['id_photo']) ? null : $_REQUEST['id_photo'];
if(is_numeric($idp)) {
  $idp_and = " AND p.id= $idp";
}


$sql = "
SELECT p.*, a.name as album , a.date
FROM photo p 
LEFT JOIN album a 
  ON a.id = p.id_album
WHERE p.status > 0
  $ida_and
  $idp_and
ORDER BY p.position ASC
";



$photos = Db::i()->getAll($sql);

$albums = Db::i()->getAll("SELECT * FROM album WHERE status > 0");

$album_photos = array();

foreach ($photos as &$photo) {
  if(empty($photo['id_album'])) {
    $photo['id_album'] = 0;
    $photo['album'] = 'Без альбому';
  }
  $ida = $photo['id_album'];
  $album_photos[$ida]['photos'][$photo['id']] = $photo;
  $album_photos[$ida]['name']  = $photo['album'];
  $album_photos[$ida]['id']  = $photo['id_album'];
}
unset($photo);
?>
<h1>Альбоми</h1>
<? foreach ($album_photos as $ida => $album) { ?>
<div class="panel panel-default">
  <div class="panel-heading toggle_next">
    <a href="/admin/photos?id_album=<?= $ida ?>"><?= $album['name'] ?></a>
  </div>
  <div class="panel-body loose-hidden">
      <div class="album-list">
        <? foreach( $album['photos'] as $photo ) { ?>
<!--            <div class="album-item col-lg-3 col-md-6 col-xs-12">-->
            <div class="album-item col-lg-3 col-md-4 col-sm-6 col-xs-12">
              <form class="album-image-form" method="post">
                <input type="hidden" name="id" value="<?= $photo['id'] ?>">
                <div class="form-group">
                  <a target="_blank" class="parent_size album-photo" href="<?= $photo['url'] ?>" style="background-image: url('<?= empty($photo['url_mini']) ? $photo['url'] : $photo['url_mini'] ?>')"></a>
                </div>
                <div class="w100 text-center">
                  <div class="pull-left btn btn-default position-decrease" title="Перемістити ліворуч">
                    &DoubleLeftArrow;
                  </div>
                  <div class="btn btn-default btn-group toggle_parent_siblings">Фото / дані</div>
                  <div class="pull-right btn btn-default position-increase" title="Перемістити праворуч">
                    &DoubleRightArrow;
                  </div>
                </div>
                <div style="display: none">
                  <div class="form-group">
                    <label class="toggle_next w100">Опис</label>
                    <textarea
                        class="form-control  not-loose-hidden "
                        name="description"
                    ><?= $photo['description'] ?></textarea>
                  </div>
                  <div class="form-group">
                    <label class=" w100 toggle_next">Альбом</label>
                    <select class="form-control   not-loose-hidden " name="id_album">
                      <option value="0">Без альбому</option>
                      <? foreach( $albums as $al) { ?>
                          <option
                              value="<?= $al['id'] ?>"
                              <?= $al['id'] == $photo['id_album'] ? 'selected' : '' ?>
                          >
                            <?= $al['name'] ?>
                          </option>
                      <? } ?>
                    </select>
                  </div>
                  <div class="form-group">
                  <label class="w100 toggle_next">Стан</label>
                  <select class="form-control   not-loose-hidden " name="status">
                    <option value="-1" <?= $photo['status'] == -1 ? 'selected' : '' ?>>Видалене</option>
                    <option value="0" <?= $photo['status'] == 0 ? 'selected' : '' ?>>Не опубліковане</option>
                    <option value="1" <?= $photo['status'] == 1 ? 'selected' : '' ?>>Опубліковане</option>
                  </select>
                </div>
                  <div class="form-group actions text-center clearfix">
                    <button name="func" value="makeCover" class="btn-warning btn col-xs-6">Зробити обкладинкою</button>
                    <button name="func" value="delete" class="btn-danger btn col-xs-6">Видалити</button>
                    <button name="func" value="edit" class="btn-info btn col-xs-12">Зберегти</button>
                  </div>
                </div>
              </form>
            </div>
        <? } ?>
      </div>
  </div>
</div>

<? } ?>
