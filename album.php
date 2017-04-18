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
$id_album = empty($_REQUEST['id']) ? -1 : intval($_REQUEST['id']);
$chpu = empty($_REQUEST['chpu']) ? '' : $_REQUEST['chpu'];
$photos = $db->getAll("
SELECT p.*, a.name as album
FROM  photo p 
JOIN album a 
  ON (p.id_album = ?i OR a.chpu LIKE ?s)
  AND a.id = p.id_album
  AND a.status = ?i
WHERE p.status > 0  
ORDER BY p.position ASC", $id_album, $chpu, Config::$ALBUM_STATUS_PUBLISHED);


$comments = array();
if(!empty($photos)) {
  $ida = $photos[0]['id_album'];
  $comments = $db->getAll("
SELECT c.* 
FROM  comment c 
JOIN photo p
  ON c.`status` > 0
  AND (p.id_album = ?i)
  AND c.id_photo = p.id
", $ida);
}



?>
<!DOCTYPE html>
<html>
<? include ('header.php'); ?>
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

<div class="content">
  <div class="album">
    <div class="albumini">
      <? foreach ( $photos as $photo) {
        Helpers::addTrans('photo_' . $photo['id'], $photo['description']);
        ?>
        <div class="mini-img" href="<?= $photo['url'] ?>" data-id="<?= $photo['id'] ?>" style="background-image: url('<?= $photo['url_mini'] ?>');"></div>
      <? } ?>

    </div>
  </div>
</div>

<? include (BASE_DIR . 'photo_popup.php')?>



<? include 'footer.php';?>

</body>

</html>
