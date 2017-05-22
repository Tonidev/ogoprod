<?php
/**
 * Date: 13.03.17
 * Time: 18:47
 */

if(!defined('BASE_DIR')) {
  define('BASE_DIR', __DIR__ .DIRECTORY_SEPARATOR);
}
require_once (BASE_DIR . 'config.php');

$db = Db::i();

$albums = $db->getAll("
SELECT a.* , p.url, p.url_mini
FROM album a 
JOIN (
  SELECT * FROM photo a 
  INNER JOIN (
    SELECT id_album as ida , MAX(`status`) as sta 
    FROM photo 
    GROUP BY id_album
    ) b
    ON a.id_album = b.ida
    AND a.status = b.sta
  ) p
  ON p.id_album = a.id
  AND p.status > 0
  AND a.status = ?i
GROUP BY a.id
ORDER BY a.date DESC ", Config::$ALBUM_STATUS_PUBLISHED);

?>
<!DOCTYPE html>
<html>
<? include('header.php') ; ?>
<body class="main">
<script>
  jQuery("document").ready(function($) {
    $('select').dropdown({});
  });
</script>

<div class="logo">
  <a href="/"></a>
</div>
<? include 'left_menu.php'; ?>
<div class="content" id="gall_cont1">
  <div class="albumslist">

    <? foreach ( $albums as $album) { ?>
      <a href="/album/<?= empty($album['chpu']) ? $album['id'] : $album['chpu'] ?>">
        <div class="album-block">
          <div class="photo gallery-photo">
            <img oncontextmenu="return false;" class="album-img" src="<?= $album['url_mini'] ?>">
            <div class="album-line"><span class="album-text"><?= $album['name'] ?></span></div>
          </div>
        </div>
      </a>
    <? } ?>

  </div>
</div>


<? include 'footer.php'; ?>

</body>

</html>
