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

$photos = $db->getAll("
SELECT *
FROM  photo
WHERE status > 0
  AND (id_album = 0 OR id_album IS NULL)
ORDER BY position ASC");

$ph_ind = 0;

$comments = $db->getAll("
SELECT c.*
FROM  comment c
JOIN photo p
  ON c.`status` > 0
  AND (p.id_album = 0 OR p.id_album IS NULL)
  AND c.id_photo = p.id
");

?>
<!DOCTYPE html>
<html>

<? include ("header.php");?>

<link rel="stylesheet" type="text/css" href="css/style.css"/>

<body style="overflow: auto"  class="main index">

<div class="logo">
    <a href="/"> </a>

</div>

<? include 'left_menu.php'; ?>

<div class="content" id="main_text">

    <p>  <h2 style="left:1.5em;text-shadow: rgba(8,204,171,2) 0 0 10px;">Backstage в OGO production</h2>
    <div style="position:relative;height:0;padding-bottom:56.25%"><iframe src="https://www.youtube.com/embed/Txo3h0ESyKo?ecver=2" width="450" height="290" frameborder="0" style="position:absolute;width:80%;height:80%;left:0" allowfullscreen></iframe></div>
    <p>  <h2 style="left:1.5em;text-shadow: rgba(8,204,171,2) 0 0 10px;">Реклама для кафе  "7 Пятниц"</h2>
    <div style="position:relative;height:0;padding-bottom:56.25%"><iframe  src="https://www.youtube.com/embed/qT40Prv7EJ0" width="450" height="290" frameborder="0" style="position:absolute;width:80%;height:80%;left:0" allowfullscreen></iframe></div>
</div>

<? include 'footer.php'; ?>
</body>
</html>
