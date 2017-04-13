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
  <div style="text-align: center; "><span id="zakaz">Заказати послугу</span></div>
  <div class="poslugi_block1">
    <div class="spisok-poslug">
      <ul id="spisok_poslug">
        <li>1. Test poslugi</li>
        <li>1. Test poslugi</li>
        <li>1. Test poslugi</li>
        <li>1. Test poslugi</li>
        <li>1. Test poslugi</li>
        <li>1. Test poslugi</li>
        <li>1. Test poslugi</li>
      </ul>
    </div>
    <div id="vvod" style="display: inline-block">
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
    <span class="pricetext" style="padding-right:1.11em;">Ф. И. О. : </span>
    <input type="text" name="name" style="text-align: center; border-radius: 5px; width: 146px;">
</div>
  <div class="phone">
    <span class="pricetext" style="padding-right:1.05em;">Телефон : </span>
    <input id="tel" onkeyup="return proverka(this);" onchange="return proverka(this);" type="text" name="phone" style="text-align: center;border-radius: 5px; width: 146px;">
  </div>

    <a href="price.php" style="margin-left:30px" class="send">Заказать</a>
    <a href="" class="send2">Вконтакте</a>
  </div>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d417.9923536919372!2d33.35976772773899!3d47.90532390999367!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf63143ccca78764c!2z0KHQtdGA0LLQuNGB0L3Ri9C5INGG0LXQvdGC0YAgItCG0KLQoSI!5e0!3m2!1sru!2sua!4v1492103517647" width="400" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>
</div>


<? include 'footer.php'; ?>

</body>

</html>
