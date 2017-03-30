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

$photos = $db->getAll("SELECT * FROM  photo WHERE status > 0");
$comments = $db->getAll("SELECT * FROM  comment WHERE status > 0");
?>
<!DOCTYPE html>
<html>
<head>
  <script type="text/javascript">

  </script>
  <meta name="charset" content="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Title</title>
<!--  <link rel="stylesheet" href="css/style.css">-->
  <script src="js/jq.js"></script>
  <script src="js/core.js"></script>
  <script src="js/touch.js"></script>
  <script src="js/dropdown.js"></script>
  <link rel="stylesheet" href="css/dropdown.css"/>
  <script src="js/sweetalert.min.js"></script>

  <link rel="stylesheet" href="css/sweetalert.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://vk.com/js/api/openapi.js?142" type="text/javascript"></script>
</head>
<body class="main">
<script>
  jQuery("document").ready(function($) {

  });
</script>

<div class="logo">
  <a href="/"></a>
</div>
<div class="left-menu">
  <ul>

    <li><a class="main" href="main.php"><span class="ico"></span><span class="text">главная</span></a></li>
    <li><a class="portfolio" href="main.php"><span class="ico"></span><span class="text">порфолио</span></a></li>
    <li><a class="services" href="price.php"><span class="ico"></span><span class="text">услуги</span></a></li>
    <li><a class="gallery" href="main.php"><span class="ico"></span><span class="text">галерея</span></a></li>

  </ul>
</div>
<div class="content">
  <div id="vvod">
    <span class="pricetext">Промо-код : </span>
    <input type="text" name="code" style="border-radius: 5px; width: 146px; text-align: center">
    <span id="discount_text" class="pricetext"></span>
  <div class="service">
    <span class="pricetext">Вид услуги :</span>
    <select name="service">
      <? foreach( Config::$PROMO_SERVICES as $k => $s) { ?>
        <option  value="<?= $k ?>"> <?= $s['name'] ?></option>
      <? } ?>
    </select>
    <span id="service_text" class="pricetext"></span>
  </div>
  <div class="fio">
    <span class="pricetext" style="padding-right:1.95em;">Ф. И. О. : </span>
    <input type="text" name="name" style="text-align: center; border-radius: 5px; width: 146px;">
</div>
  <div class="phone">
    <span class="pricetext" style="padding-right:1.05em;">Телефон : </span>
    <input id="tel" onkeyup="return proverka(this);" onchange="return proverka(this);" type="text" name="phone" style="text-align: center;border-radius: 5px; width: 146px;">
  </div>

    <a href="price.php" style="margin-left:30px" class="send">Заказать</a>
    <a href="" class="send2">Вконтакте</a>
  </div>
</div>
<!--
<footer>

</footer>
-->

<div id="photo_popup" data-image="">
  <div id="photo_popup_container">
    <div id="photo_popup_image">
      <span id="photo_popup_close">&times;</span>
      <img id="photo_popup_img" src="/backgrounds/3.jpg">
      <div id="photo_popup_menu">
       <? if(false) { ?>
         <div id="photo_popup_menu_btn">Комментарии</div>
       <? } ?>
      </div>
      <div id="photo_popup_comments">
        <div id="photo_popup_comments_header">Это не мнение, я просто правду говорю</div>
        <div id="photo_popup_comments_list">
          <? foreach( $comments as $comment) { ?>
            <div class="comment">
              <div class="avatar" style="background-image: url('<?= $comment['avatar']?>')"></div>
              <div class="author"><?= $comment['author']?></div>
              <div class="text"><?= $comment['text']?></div>
            </div>

          <? } ?>
          <? for($i = 10; $i < 10; $i++) { ?>
            <div class="comment">
              <div class="avatar"></div>
              <div class="author">Дмитрiй Безпалюкъ</div>
              <div class="text">Это не мнение, я просто правду говорю.
                -Уметь надо мнения выслушивать.
                😄</div>
            </div>
          <? } ?>
        </div>
        <div id="add_comment">
          <textarea name="comment"></textarea>
          <button class="button1" type="button">Отправить комментарий</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  appid = 5941079;
  VK.init({
    apiId: appid
  });
</script>
<script src="/js/startscr.js"></script>
</body>

</html>
