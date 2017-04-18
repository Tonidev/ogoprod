<?php

if(!defined('BASE_DIR')) {
  define('BASE_DIR', __DIR__ .DIRECTORY_SEPARATOR);
}
require_once (BASE_DIR . 'config.php');

$db = Db::i();

$posts = $db->getAll("
SELECT p.* , ph.url, ph.url_mini
FROM post p 
LEFT JOIN photo ph
  ON p.id_photo = ph.id
WHERE p.status > 0");

$comments = $db->getAll("
SELECT c.* 
FROM  comment c 
JOIN photo p
  ON c.`status` > 0
  AND (p.id_album = 0 OR p.id_album IS NULL) 
  AND c.id_photo = p.id
JOIN post 
    ON p.id = post.id_photo
    AND post.status > 0
");
?>
<!DOCTYPE html>
<html>
<? include ("header.php");?>
<head>
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body class="main blog">
<?
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

<div class="content">

  <? foreach($posts as $post) {
    Helpers::addTrans('photo_' . $post['id'], $post['description']);
    ?>
    <div class="photo-block">
      <div class="post_header">
        <h1 class="title"><?= $post['title'] ?></h1>
        <div class="f-right date"><?= date('d/m/Y', strtotime($post['date']) ) ?></div>
      </div>
      <div class="photo blog-cover">
        <a class="mobile-hide" href="/blog/<?= empty($post['chpu']) ? $post['id'] : $post['chpu'] ?>"><img
              href="<?= $post['url'] ?>"
              src="<?= $post['url'] ?>"
              data-id="<?= $post['id'] ?>">
        </a>
        <a class="desktop-hide" href="/blog/<?= empty($post['chpu']) ? $post['id'] : $post['chpu'] ?>"><img
             href="<?= $post['url'] ?>"
             src="<?= empty($post['url_mini'])
                 ? $post['url']
                 : $post['url_mini'] ?>"
             data-id="<?= $post['id'] ?>">
        </a>
      </div>
      <div class="description"><?= $post['description'] ?><span class="eliplse">&hellip;</span><a class="read_full" href="/blog/<?= empty($post['chpu']) ? $post['id'] : $post['chpu'] ?>">Читати далі</a> </div>

    </div>
  <? } ?>
  <!--margin: 0 auto;
  display: inline-block;
  float: left;-->

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

<? include 'footer.php'; ?>
</body>
</html>
