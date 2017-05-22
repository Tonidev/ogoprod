<?php


$func = empty($_REQUEST['func']) ? null : $_REQUEST['func'];
if (!empty($func)) {
  if(!empty($_REQUEST['ajax'])) {
    switch ($func) {
      case "delete":
        $pid = intval($_REQUEST['id']);
        if(empty($pid)) {
          Helpers::jsonError("Не вказаний  ID поста");
        } else {
          Db::i()->query("UPDATE post SET status = -1 WHERE id = $pid");
          Helpers::jsonOk();
        }
        break;
      default :
        Helpers::jsonError("Невідома функція");
    }
    die();
  }
}

$posts = Db::i()->getAll("
SELECT p.* , ph.url, ph.url_mini
FROM post p 
LEFT JOIN photo ph
  ON p.id_photo = ph.id
WHERE p.status >= 0 ");

?>
<h1>Блог</h1>
<div><a class="btn btn-default" href="/admin/post/add">Додати запис</a></div>

<? foreach( $posts as $post) { ?>
  <div class="col-xs-12 col-md-6 post panel" data-id="<?= $post['id'] ?>">
    <div class="panel-heading post_title">
      <?= $post['title'] ?>
    </div>
    <div class="panel-body">
      <div class="post_photo" style="background-image: url('<?= empty($post['url_mini']) ? $post['url_mini'] : $post['url_mini'] ?>')">
      </div>
      <div class="post_description">
        <?= $post['description'] ?>
      </div>
    </div>
    <div class="panel-footer post_actions">
      <a href="/admin/post/<?= $post['id'] ?>" class="btn btn-default edit">Редагувати</a>
      <button class="btn btn-danger delete">Видалити</button>
    </div>
  </div>
<? } ?>
