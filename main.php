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
<body class="main">
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


</div>


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
  appid = 5941079;
  VK.init({
    apiId: appid
  });
</script>
<script src="/js/startscr.js"></script>
</body>

</html>
