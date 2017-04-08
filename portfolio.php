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
SELECT p.*, a.name as album, a.status as album_status
FROM  photo p 
JOIN album a 
  ON a.id = p.id_album
  AND ( a.status = ?i OR a.status = ?i)
WHERE p.status > 0  
ORDER BY p.position ASC", Config::$ALBUM_STATUS_PORTFOLIO_VADIM, Config::$ALBUM_STATUS_PORTFOLIO_ARCHIL);

$comments = array();

if(!empty($photos)) {
  $portfolio_album_ids = array();

  foreach ($photos as $photo) {
    $portfolio_album_ids[$photo['id_album']] = $photo['id_album'];
  }

  $id_album_sql = join(', ', $portfolio_album_ids);

  $comments = $db->getAll("
SELECT c.* 
FROM  comment c 
JOIN photo p
  ON c.`status` > 0
  AND p.id_album IN ( ?p )
  AND c.id_photo = p.id
", $id_album_sql);

}

?>
<!DOCTYPE html>
<html>
<? include ('header.php');?>
<head>
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body class="main">
<script>
  jQuery("document").ready(function($) {
    $('select').dropdown({});
  });
</script>

<div class="logo">
  <a href="/"></a>
</div>

<? include ('left_menu.php'); ?>

<div class="content">

  <div class="port_block">


    <div class="port_album">
      <div class="port_photo">
        <img class="port_img" src="img/VAD.jpg">
        <div class="port-line"><span class="port-text">Вадим Оголяр</span></div>
      </div>
    </div>

    <div class="port_album">
      <div class="port_photo">
        <img class="port_img" src="img/AR.jpg">
        <div class="port-line"><span class="port-text">Арчил Сванидзе</span></div>
      </div>
    </div>

    <!--      TODO make protfolio albums-->
    <div class="port1">
      <? foreach ( $photos as $photo) {
        if($photo['album_status'] != Config::$ALBUM_STATUS_PORTFOLIO_VADIM)
          continue;
        ?>
        <div>
          <img href="<?= $photo['url'] ?>"
               src="<?= empty($photo['url_mini']) ? $photo['url'] : $photo['url_mini'] ?>"
               data-id="<?= $photo['id'] ?>"
          >
        </div>
      <? } ?>
    </div>

    <div class="port1">
      <? foreach ( $photos as $photo) {
        if($photo['album_status'] != Config::$ALBUM_STATUS_PORTFOLIO_ARCHIL)
          continue;
        ?>
        <div>
          <img href="<?= $photo['url'] ?>"
               src="<?= empty($photo['url_mini']) ? $photo['url'] : $photo['url_mini'] ?>"
               data-id="<?= $photo['id'] ?>"
          >
        </div>
      <? } ?>
    </div>

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
    $('.port1').slick({
      centerMode: true,
      centerPadding: '60px',
      adaptiveHeight : false,
      variableWidth : true,
      slidesToShow: 1
    });
    /*
     $('.port2').slick({
     centerMode: true,
     centerPadding: '60px',
     slidesToShow: 1,
     responsive: [
     {
     breakpoint: 768,
     settings: {
     arrows: false,
     centerMode: true,
     centerPadding: '40px',
     slidesToShow: 1
     }
     },
     {
     breakpoint: 480,
     settings: {
     arrows: false,
     centerMode: true,
     centerPadding: '40px',
     slidesToShow: 1
     }
     }
     ]
     });
     */
    appid = 5941079;
    VK.init({
      apiId: appid
    });
  </script>
  <script src="/js/startscr.js"></script>
</body>

</html>
