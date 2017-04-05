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

$photos = $db->getAll("SELECT * FROM  photo WHERE status >= 0");
$comments = $db->getAll("SELECT * FROM  comment WHERE status > 0");
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="charset" content="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Title</title>
<!--  <link rel="stylesheet" href="css/style.css">-->
  <script src="js/jq.js"></script>
  <script src="js/sweetalert.min.js"></script>
  <link rel="stylesheet" href="css/sweetalert.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://vk.com/js/api/openapi.js?142" type="text/javascript"></script>
  <script>
    function getSocTitle() {
      return '<img class="social" src="img/soc-vk.png"/><img class="social" src="img/soc-facebook.png"/><img class="social" src="img/soc-instagram.png"/><div><a href="main.php" class="button1" style="margin-right: 19%;">ВХОД</a></div>';
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
</head>
<body class="main">
<DIV id="logobg">
  <div id="logotmp">
    <div id="start"  width="2000" height="1200" ></div>
  </div>
</DIV>
<div class="logo">
  <a href="/"></a>
</div>
<div class="left-menu">
  <ul>

    <li><a class="main" href="main.php"><span class="ico"></span><span class="text">главная</span></a></li>
    <li><a class="portfolio" href="main.php"><span class="ico"></span><span class="text">порфолио</span></a></li>
    <li><a class="services" href="price.php"><span class="ico"></span><span class="text">услуги</span></a></li>
    <li><a class="gallery" href="gallery.php"><span class="ico"></span><span class="text">альбомы</span></a></li>


  </ul>
</div>
<div class="content">

  <? foreach(  $photos as $photo) { ?>
    <div class="photo-block">
      <div class="photo">
        <img class="mobile-hide"
             href="<?= $photo['url'] ?>"
             src="<?= $photo['url'] ?>"
             data-id="<?= $photo['id'] ?>">
        <img class="desktop-hide"
             href="<?= $photo['url'] ?>"
             src="<?= empty($photo['url_mini'])
                 ? $photo['url']
                 : $photo['url_mini'] ?>"
             data-id="<?= $photo['id'] ?>">
      </div>
      <div class="description"><?= $photo['description'] ?></div>
    </div>
  <? } ?>

  <!--

  <div class="photo-block">
    <div class="photo"><img src="http://files2.geometria.ru/pics/original/058/021/58021259.jpg"></div>
    <div class="description">Фото №1 трататата тут типо описание и всё понятно</div>
  </div>

  <div class="photo-block">
    <div class="photo"><img src="http://files2.geometria.ru/pics/original/058/021/58021475.jpg"></div>
    <div class="description">Фото №1 трататата тут типо описание и всё понятно</div>
  </div>-->

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
            <div class="comment" data-id_photo="<?= $comment['id_photo'] ?>">
              <div class="avatar" style="background-image: url('<?= $comment['avatar']?>')"></div>
              <div class="author"><?= $comment['author']?></div>
              <div class="text"><?= $comment['text']?></div>
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
