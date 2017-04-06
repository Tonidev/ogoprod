<?php

$ida = !isset($_REQUEST['id_album']) ? null : intval($_REQUEST['id_album']);
$ida_and = '';
if(is_numeric($ida)) {
  $ida_and = " AND p.id_album = $ida";
}

$sql = "
SELECT p.*, a.name as album , a.date
FROM photo p 
LEFT JOIN album a 
  ON a.id = p.id_album
WHERE p.status > 0
  $ida_and
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
            <div class="album-item col-lg-3 col-md-6 col-xs-12">
              <form class="album-image-form" method="post">
                <input type="hidden" name="id" value="<?= $photo['id'] ?>">
                <div class="form-group">
                  <a target="_blank" class="parent_size album-photo" href="<?= $photo['url'] ?>" style="background-image: url('<?= $photo['url_mini'] ?>')"></a>
                </div>
                <div class="btn btn-default w100 toggle_siblings">
                  Фото / дані
                </div>
                <div style="display: none">
                  <div class="form-group">
                    <label class="toggle_next">Опис</label>
                    <textarea
                        class="form-control"
                        name="description"
                        style="display: none"
                    ><?= $photo['description'] ?></textarea>
                  </div>
                  <div class="form-group">
                    <label class="toggle_next">Альбом</label>
                    <select class="form-control" name="id_album">
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
                  <label>Стан</label>
                  <select class="form-control" name="status">
                    <option value="-1" <?= $photo['status'] == -1 ? 'selected' : '' ?>>Видалене</option>
                    <option value="0" <?= $photo['status'] == 0 ? 'selected' : '' ?>>Не опубліковане</option>
                    <option value="1" <?= $photo['status'] == 1 ? 'selected' : '' ?>>Опубліковане</option>
                  </select>
                </div>
                  <div class="form-group">
                    <button name="func" value="edit" class="btn-default btn">Зберегти</button>
                  </div>
                </div>
              </form>
            </div>
        <? } ?>
      </div>
  </div>
</div>

<? } ?>
