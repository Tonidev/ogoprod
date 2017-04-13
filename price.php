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
</div>


<? include 'footer.php'; ?>

</body>

</html>
