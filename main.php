<?php
/**
 * Date: 13.03.17
 * Time: 18:47
 */
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
  <script type="text/javascript">
    appid = 123456789;
    VK.init({
      apiId: appid
    });
  </script>
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
  <div class="photo-block">
    <div class="photo"><img src="http://files.geometria.ru/pics/original/060/185/60185508.jpg"></div>
    <div class="description">Фото №1 трататата тут типо описание и всё понятно</div>
  </div>

  <div class="photo-block">
    <div class="photo"><img src="http://files2.geometria.ru/pics/original/058/021/58021259.jpg"></div>
    <div class="description">Фото №1 трататата тут типо описание и всё понятно</div>
  </div>

  <div class="photo-block">
    <div class="photo"><img src="http://files2.geometria.ru/pics/original/058/021/58021475.jpg"></div>
    <div class="description">Фото №1 трататата тут типо описание и всё понятно</div>
  </div>

</div>
<!--
<footer>

</footer>
-->
<div id="photo_popup">
  <div id="photo_popup_container">
    <div id="photo_popup_image">
      <span id="photo_popup_close">&times;</span>
      <img id="photo_popup_img" src="http://files.geometria.ru/pics/original/060/185/60185508.jpg">
      <div id="photo_popup_menu">
        <div id="photo_popup_menu_btn">Комментарии</div>
      </div>
    </div>
  </div>
</div>

</body>

</html>
