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

function indexPhotoHtml($photo) {
  ob_start();
  ?>
  <img class="index_photo" href="<?= $photo['url'] ?>" src="<?= empty($photo['url_mini']) ? $photo['url'] : $photo['url_mini'] ?>" style="width: 91%;" data-id_photo="<?= $photo['id'] ?>">
  <?
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}

?>
<!DOCTYPE html>
<html>
<? include ("header.php");?>

<link rel="stylesheet" type="text/css" href="css/style.css"/>
<style>body.content
  {
    display: none;
  }
</style>
<body style="overflow: auto"  class="main index">
<? if(empty($_SESSION['no_index']) || (time() - $_SESSION['no_index']) > 60*60*24) { ?>
  <div class="vova1">
    <div class="vova2">

      <a href="" onclick="swal({
  html : true,
  title : getSocTitle(),
  allowOutsideClick : true,
  showConfirmButton: false
}); return false;" id="but" class="button">oGo Production</a>

      <div id="start"  width="2000" height="1200" ></div>


    </div>
  </div>
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

<div class="content" id="main_text">
 <span><p> <h1 style="  text-shadow: rgba(8,204,171,1) 0 0 10px;">Вітаємо на сайті oGo production студії:</h1></p>

   <p>  <h2 style="  text-shadow: rgba(8,204,171,2) 0 0 10px;">oGo production - це:</h2>
  <ul><li> Найновіше фото- та відеообладнання в місті;</li>
  <li> Професійна команда з багаторічним досвідом роботи;</li>
  <li> Широкий спектр послуг</li>
  <li> Індивідуальній підхід до кожного</li>
  <li> Цікаві пропозиції постійним клієнтам</li>
    </ul>
   </p>
   <h3 style="  text-shadow: rgba(8,204,171,1) 0 0 10px;">▪ Фотошкола</h3>
  <p>Навчання у школі справжнього фотографа розкриє секрети зйомки у різних жанрах з можливостю працевлаштування по закінченню курсу.
  Ти новачок або вже профі? Обирай свій "level" та приєднуйся до команди oGo production!
</p>
  <h3 style="  text-shadow: rgba(8,204,171,1) 0 0 10px;">▪ Модельна школа</h3>
  <p>Стань універсальною моделлю безкоштовно з oGo production!</p>
   <p>Ми гарантуємо якісний продукт за короткий термін. Навіщо чекати? Дзвони 0986130909</p>

 </span>
  <div class="opisph">
    <? if(!empty($photos[$ph_ind])) { echo indexPhotoHtml($photos[$ph_ind]); $ph_ind++; } ?>
    <span id="opis"><p style="text-align: center">Бездоганна якість фото&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></span>
    <? if(!empty($photos[$ph_ind])) { echo indexPhotoHtml($photos[$ph_ind]); $ph_ind++; } ?>
    <span id="opis"><p style="text-align: center">Креативні ідеї &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></span>
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
