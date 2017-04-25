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

$ph_ind = 0;
$photos = $db->getAll("
SELECT *
FROM  photo
WHERE status > 0
  AND (id_album = 13 )
ORDER BY position ASC");

$comments = $db->getAll("
SELECT c.*
FROM  comment c
JOIN photo p
  ON c.`status` > 0
  AND p.id_album = 13
  AND c.id_photo = p.id
");
?>
<!DOCTYPE html>
<html>
<head>

    <? include ("header.php");?>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body class="main team">
<? if(empty($_SESSION['no_index']) || (time() - $_SESSION['no_index']) > 60*60*24) { ?>
<? }
$_SESSION['no_index'] = time();
?>

<DIV id="logobg">
    <div id="logotmp">
        <div id="start"  width="2000" height="1200" ></div>
    </div>
</DIV>
<div class="logo">
    <a href="/"></a>
</div>

<? include 'left_menu.php'; ?>

<div class="content">
    <div id="teamblock">
    <div style="width: 240px; padding-right: 20px;">
    <img href="<?= $photos[$ph_ind]['url'] ?>" data-id="<?= $photos[$ph_ind]['id'] ?>" style="width:100%; border-radius: 50px;" src="<?= $photos[$ph_ind]['url_mini'] ?>">
      <?
      Helpers::addTrans('photo_' . $photos[$ph_ind]['id'], $photos[$ph_ind]['description']);
      $ph_ind++; ?>
<!--    <img style="width:100%; border-radius: 50px;" src="img/team/vad-mini.jpg">-->
    <p style="text-align: center;font-family: PNG1;font-size: 23px; color: white;position: relative;top: -18px;">Вадим Оголяр</p>
    </div>
    <span style="padding-left:15px;font-family: PNG1;font-size: 18px;color: white;position: relative;top: -28px;">
        <h3 style="padding-left: 1em;">Керівник oGo production.</h3>
<ul>
<li>Викладач фотошколи (Курс Elementary, Дитяча фотошкола)</li>
    <li>Студійна та рекламна зйомка</li>
    <li>Ютюб відео-зйомка</li>
<li>Питання по співпраці</li>
<li>Взаємодія зі спонсорами і партнерами</li>
</ul>

    </span>
    </div>
<p></p>
    <div id="teamblock">
        <div style="width: 240px; padding-right: 20px;">
          <img href="<?= $photos[$ph_ind]['url'] ?>" data-id="<?= $photos[$ph_ind]['id'] ?>" style="width:100%; border-radius: 50px;" src="<?= $photos[$ph_ind]['url_mini'] ?>">
          <?
          Helpers::addTrans('photo_' . $photos[$ph_ind]['id'], $photos[$ph_ind]['description']);
          $ph_ind++; ?>
<!--          <img style="width:100%; border-radius: 50px;" src="img/team/arch-mini.jpg">-->
            <p style="text-align: center;font-family: PNG1;font-size: 23px; color: white;position: relative;top: -18px;">Арчил Сванидзе</p>
        </div>
    <span style="padding-left:15px;font-family: PNG1;font-size: 18px;color: white;position: relative;top: -28px;">
<h3 style="padding-left: 1em;">Викладач фотошколи</h3>
        <ul>
        <li>Курси ретушування</li>
        <li>Курс Advance</li>
        <li>Вiдеограф</li>
        <li>Фотограф</li>
            </ul>
    </span>
    </div>
<p></p>
    <div id="teamblock">
        <div style="width: 240px; padding-right: 20px;">
          <img href="<?= $photos[$ph_ind]['url'] ?>" data-id="<?= $photos[$ph_ind]['id'] ?>" style="width:100%; border-radius: 50px;" src="<?= $photos[$ph_ind]['url_mini'] ?>">
          <?
          Helpers::addTrans('photo_' . $photos[$ph_ind]['id'], $photos[$ph_ind]['description']);
          $ph_ind++; ?>
<!--          <img style="width:100%; border-radius: 50px;" src="img/team/anna-mini.jpg">-->
            <p style="text-align: center;font-family: PNG1;font-size: 23px; color: white;position: relative;top: -18px;">Анна Vie</p>
        </div>
    <span style="padding-left:15px;font-family: PNG1;font-size: 18px;color: white;position: relative;top: -28px;">
<h3 style="padding-left: 1em;">Адміністратор.</h3>
        <ul>
<li>Прийом заказів</li>
<li>Питання стосовно реклами</li>
<li>Розміщення матеріалу на сайті</li>
        </ul>

    </span>
    </div>

    </div>

<? include (BASE_DIR . 'photo_popup.php')?>

<script type="text/javascript">
    function getSocTitle() {
        return '<img class="social" src="img/soc-vk.png"/><img class="social" src="img/soc-facebook.png"/><img class="social" src="img/soc-instagram.png"/><div><a onclick="entermain(); return false;" class="button1" style="margin-right: 19%;">ВХОД</a></div>';
    }

    var backgi=1;
    setInterval(function(){backg()},8000);
    function backg()
    {
        backgi=backgi%3+1;
        var $start = $("#start");
        $start.animate({'opacity':'0'},800,function(){
            $start.css('background-image', 'url(/backgrounds/'+backgi+'.jpg)');
            $start.css('background-size', 'contain');
            $start.css('background-position', 'center');
            $start.animate({'opacity':'1'},800);});
    }


</script>
<? include 'footer.php'; ?>
</body>
</html>
