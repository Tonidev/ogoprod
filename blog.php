<?php

if(!defined('BASE_DIR')) {
  define('BASE_DIR', __DIR__ .DIRECTORY_SEPARATOR);
}
require_once (BASE_DIR . 'config.php');

$db = Db::i();

$post = array();
$posts = array();

if(!empty($_REQUEST['chpu'])) {
  $chpu = $db->parse('?s', $_REQUEST['chpu']);
  $post = $db->getRow("SELECT p.* , ph.url, ph.url_mini, ph.description as photo_description
FROM post p 
LEFT JOIN photo ph
  ON p.id_photo = ph.id
WHERE p.status > 0
AND p.chpu LIKE $chpu
ORDER BY date DESC");
}
if(!empty($_REQUEST['id'])) {
  $id = $db->parse('?i', $_REQUEST['id']);
  $post = $db->getRow("SELECT p.* , ph.url, ph.url_mini, ph.description as photo_description
FROM post p 
LEFT JOIN photo ph
  ON p.id_photo = ph.id
WHERE p.status > 0
AND p.id LIKE $id
ORDER BY date DESC");
}

if(empty($post)) {
  $posts = $db->getAll("
SELECT p.* , ph.url, ph.url_mini, ph.description as photo_description
FROM post p 
LEFT JOIN photo ph
  ON p.id_photo = ph.id
WHERE p.status > 0
ORDER BY date DESC 
");
}

if(empty($post)) {
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
} else {
  $comments = $db->getAll("
SELECT c.* 
FROM  comment c 
JOIN photo p
  ON c.`status` > 0
  AND (p.id_album = 0 OR p.id_album IS NULL) 
  AND c.id_photo = p.id
JOIN post 
    ON p.id = post.id_photo
    AND post.id = ?i
", $post['id']);
}

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

<div class="content" id="blog_cont">

  <?
  if(empty($post)) {
    foreach($posts as $post) {
    Helpers::addTrans('photo_' . $post['id'], $post['photo_description']);
    ?>
    <div class="photo-block">
      <div class="post_header">
        <h1 class="title" style="padding-left:2em;"><?= $post['title'] ?></h1>
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
  <? }
  } else { ?>
    <div id="blog_post">
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
        <div class="description"><?= $post['content'] ?> </div>

      </div>
    </div>
  <?  }
  ?>
  <!--margin: 0 auto;
  display: inline-block;
  float: left;-->

</div>


<? include (BASE_DIR . 'photo_popup.php')?>


<? include 'footer.php'; ?>
</body>
</html>
