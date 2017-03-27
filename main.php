<?php
/**
 * Date: 13.03.17
 * Time: 18:47
 */

require_once (__DIR__ . DIRECTORY_SEPARATOR .'safemysql.class.php');

$db = new SafeMySQL(array('user' => 'root', 'pass' => 'kane-ga', 'db' => 'ogoprod'));
$photos = $db->getAll("SELECT * FROM  photo WHERE status > 0");
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
</head>
<body class="main">
<div class="logo">
  <a href="/"></a>
</div>
<div class="left-menu">
  <ul>

    <li><a class="main" href="main.php"><span class="ico"></span><span class="text">главная</span></a></li>
    <li><a class="portfolio" href="main.php"><span class="ico"></span><span class="text">порфолио</span></a></li>
    <li><a class="services" href="main.php"><span class="ico"></span><span class="text">услуги</span></a></li>
    <li><a class="gallery" href="main.php"><span class="ico"></span><span class="text">галерея</span></a></li>
    <!--    <li>sdsgerersa eesr</li>-->

    <!--<li><a class="main" href="main.php"><img src="img/menu/ico6.png" style="width: 34px; height: 34px;" class="ico"><span class="text">главная</span></a></li>
    <li><a class="portfolio" href="main.php"><img src="img/menu/ico4.png" style="width: 34px; height: 34px;" class="ico"><span class="text">портфолио</span></a></li>
    <li><a class="services" href="main.php"><img src="img/menu/ico1.png" style="width: 34px; height: 34px;" class="ico"><span class="text">услуги</span></a></li>
    <li><a class="gallery" href="main.php"><img src="img/menu/ico3.png" style="width: 34px; height: 34px;" class="ico"><span class="text">галерея</span></a></li>-->
  </ul>
</div>
<div class="content">

  <? foreach(  $photos as $photo) { ?>
    <div class="photo-block">
      <div class="photo"><img src="<?= $photo['url'] ?>" data-id="<?= $photo['id'] ?>"></div>
      <div class="description"><?= $photo['description']; //Фото №1 трататата тут типо описание и всё понятно ?></div>
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
