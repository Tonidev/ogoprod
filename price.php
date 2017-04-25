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
<? include ('header.php'); ?>

<head>
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body class="main">
<script>
  jQuery("document").ready(function($) {

  });
</script>

<div class="logo">
  <a href="/"></a>
</div>
<? include 'left_menu.php'; ?>
<div class="content">

  <div class="poslugi_block1">
    <div class="spisok-poslug">
      <div style="text-align: center;padding-left: 3em;"><span id="zakaz">Перелiк послуг</span></div>
      <ul id="spisok_poslug" style="text-align: initial">
        <li data-usluga="photo-usluga1" >Студійна фотозйомка <span class="detal">(Детальнiше)</span></li>
        <li data-usluga="photo-usluga2" >Виїздна фотозйомка <span class="detal">(Детальнiше)</span></li>
        <li data-usluga="photo-usluga3" >Відеозйомка <span class="detal">(Детальнiше)</span></li>
        <li>Обробка \ ретушування фотографій </li>
        <li>Фотошкола oGo Production</li>
      </ul>
    </div>
    <div id="vvod" style="display: inline-block">
      <div id="vvod_logo"><span id="zakaz2" style="padding-right: 5em">Замовити послугу</span></div>
    <span class="pricetext">Промо-код : </span>
    <input type="text" name="code" style="border-radius: 5px; width: 146px; text-align: center">
    <span id="discount_text" class="pricetext"></span>
  <div class="service">
    <span class="pricetext">Вид послуги :</span>
    <select name="service">
      <? foreach( Config::$PROMO_SERVICES as $k => $s) { ?>
        <option  value="<?= $k ?>"> <?= $s['name'] ?></option>
      <? } ?>
    </select>
    <span id="service_text" class="pricetext"></span>
  </div>
  <div class="fio">
    <span class="pricetext" style="padding-right:0.45em;">Ваше iм'я : </span>
    <input type="text" name="name" style="text-align: center; border-radius: 5px; width: 146px;">
</div>
  <div class="phone">
    <span class="pricetext" style="padding-right: 0.75em;">Телефон : </span>
    <input id="tel" onkeyup="return proverka(this);" onchange="return proverka(this);" type="text" name="phone" style="text-align: center;border-radius: 5px; width: 146px;">
  </div>

    <a href="price.php" style="margin-left:5px" class="send">Замовити</a>
    <a href="" class="send2">Вконтакте</a>
  </div>
    <div class="poslugi_block2">
      <span style="font-family: PNG1;font-size:17px;color:white">
        <h2>Контактнi данi:</h2>
        <p>Адмiнiстратор: <seo style=" text-shadow: rgba(8,204,171,1) 0 0 3px; font-size: 20px;">Анна Vie</seo>
        Номер телефону: +380986130909</p>
        <p>Telegramm: +380986130909
        Viber: +380986130909</p>

      </span>
    </div><iframe id="frame" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d971.7312379156301!2d33.35960000000001!3d47.90536!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf63143ccca78764c!2z0KHQtdGA0LLQuNGB0L3Ri9C5INGG0LXQvdGC0YAgItCG0KLQoSI!5e1!3m2!1sru!2sua!4v1492166000228" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe></div>

</div>


<? include 'footer.php'; ?>

<div id="photo-usluga1" class="overlay">
  <div class="popup" style="width: 350px;background-color: white;">
    <h2>Студійна фотозйомка:</h2>
    <p>
    <li style="padding-top: 1em;">Студійна фотозйомка:
    <li style="padding-top: 1em;">Зйомка портфоліо
    <li style="padding-top: 1em;">"Love story"
    <li style="padding-top: 1em;">Рекламна зйомка
    <li style="padding-top: 1em;">Бізнес-портрет
    </p>
    <button class="close" title="Закрыть" onclick="document.getElementById('photo-usluga').style.display='none';"></button>
  </div>
</div>

<div id="photo-usluga2" class="overlay">
  <div class="popup" style="width: 365px;background-color: white;">
    <h2>Виїздна фотозйомка:
    </h2>
    <p>
      <li style="padding-top: 1em;">Весілля і "Love story"
      <li style="padding-top: 1em;">"En plein air" - зйомка на відкритому повітрі
      <li style="padding-top: 1em;">Корпоративи
      <li style="padding-top: 1em;">Репортажна фотозйомка подій
    <li style="padding-top: 1em;">Рекламна фотозйомка
    </p>
    <button class="close" title="Закрыть" onclick="document.getElementById('photo-usluga2').style.display='none';"></button>
  </div>
</div>

<div id="photo-usluga3" class="overlay">
  <div class="popup" style="width: 350px;background-color: white;">
    <h2>Відеозйомка:
    </h2>
    <p>
    <li style="padding-top: 1em;">Весілля
    <li style="padding-top: 1em;">Промо-роліки
    <li style="padding-top: 1em;">Відеоогляди
    <li style="padding-top: 1em;">Відеоуроки
    </p>
    <button class="close" title="Закрыть" onclick="document.getElementById('photo-usluga3').style.display='none';"></button>
  </div>
</div>
</body>

</html>
