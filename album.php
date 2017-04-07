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
      <? foreach ( $photos as $photo) { ?>
        <div class="mini-img" href="<?= $photo['url'] ?>" style="background-image: url('<?= $photo['url_mini'] ?>');"></div>
      <? } ?>
<!--
      <div class="mini-img" style="background-image: url('albums/1/OGO_4044.jpg');"></div>
      <div class="mini-img" style="background-image: url('albums/1/OGO_4145.jpg');"></div>
      <div class="mini-img" style="background-image: url('albums/1/OGO_4159.jpg');"></div>
      <div class="mini-img" style="background-image: url('albums/1/OGO_4168.jpg');"></div>
      <div class="mini-img" style="background-image: url('albums/1/OGO_4247.jpg');"></div>
      <div class="mini-img" style="background-image: url('albums/1/OGO_4266.jpg');"></div>
      <div class="mini-img" style="background-image: url('albums/1/OGO_8896.jpg');"></div>
      <div class="mini-img" style="background-image: url('albums/1/OGO_4182.jpg');"></div>
      <div class="mini-img" style="background-image: url('albums/1/OGO_4044.jpg');"></div>
      <div class="mini-img" style="background-image: url('albums/1/OGO_4145.jpg');"></div>
      <div class="mini-img" style="background-image: url('albums/1/OGO_4159.jpg');"></div>
      <div class="mini-img" style="background-image: url('albums/1/OGO_4168.jpg');"></div>
      <div class="mini-img" style="background-image: url('albums/1/OGO_4247.jpg');"></div>
      <div class="mini-img" style="background-image: url('albums/1/OGO_4266.jpg');"></div>
      <div class="mini-img" style="background-image: url('albums/1/OGO_8896.jpg');"></div>
-->
    </div>
  </div>
</div>
<!--
<footer>

</footer>
-->
<script type="text/javascript">
  appid = 5941079;
  VK.init({
    apiId: appid
  });
</script>
<script src="/js/startscr.js"></script>
</body>

</html>
