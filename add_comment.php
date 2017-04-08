<?php
/**
 * Created by PhpStorm.
 * User: shikon
 * Date: 27.03.17
 * Time: 1:36
 */
if(!defined('BASE_DIR')) {
  define('BASE_DIR', __DIR__ .DIRECTORY_SEPARATOR);
}
require_once (BASE_DIR . 'config.php');


if(empty($_REQUEST['avatar'])) {
  die('error');
} else {
  $avatar = $_REQUEST['avatar'];
}

if(empty($_REQUEST['author'])) {
  die('error');
} else {
  $author = $_REQUEST['author'];
}

if(empty($_REQUEST['vk_id'])) {
  die('error');
} else {
  $vk_id = $_REQUEST['vk_id'];
}

if(empty($_REQUEST['id_photo'])) {
  die('error');
} else {
  $id_photo = $_REQUEST['id_photo'];
}

if(empty($_REQUEST['text'])) {
  die('error');
} else {
  $text = $_REQUEST['text'];
}


require_once (__DIR__ . DIRECTORY_SEPARATOR .'safemysql.class.php');

$db = new SafeMySQL(Config::$db_connection_string);

$res = $db->query("INSERT INTO comment (id_photo, avatar, author, text, vk_id) VALUES (?i, ?s, ?s, ?s, ?s)", $id_photo, $avatar, $author, $text, $vk_id);

if(!$res) {
  die('error');
}
?>


<div class="comment" data-id_photo="<?= $id_photo ?>">
  <div class="avatar" style="background-image: url('<?= $avatar ?>')"></div>
  <div class="author"><?= $author ?></div>
  <div class="text"><?= $text ?></div>
</div>
