<?php


$func = empty($_REQUEST['func']) ? null : $_REQUEST['func'];
if (!empty($func)) {
  if(!empty($_REQUEST['ajax'])) {
    switch ($func) {
      case 'markComment':
        $id = empty($_REQUEST['id']) ? '' : intval($_REQUEST['id']);
        $status = empty($_REQUEST['status']) ? '' : intval($_REQUEST['status']);
        if(empty($id)) {
          Helpers::jsonError("ID коментаря не був переданий");
        } else {
          if(empty($status)) {
            Helpers::jsonError("Статус коментаря не був переданий");
          } else {
            if($status == -1) {
              Db::i()->query("DELETE FROM comment WHERE id = $id");
            } else {
              Db::i()->query("UPDATE comment SET status = $status WHERE id = $id");
            }
            Helpers::jsonOk();
          }
        }
        break;
      default :
        Helpers::jsonError("Невідома функція");
    }
    die();
  }
}

$comments = Db::i()->getAll("SELECT * FROM comment WHERE status >= 0 ");

?>

<? foreach( $comments as $comment) { ?>
  <div class="col-xs-6 col-md-4 comment">
    <div class="table-bordered clearfix">
      <div class="col-xs-9 ">
        <div class="author">
          <?= $comment['author'] ?>
        </div>
        <div class="text">
          <?= $comment['text'] ?>
        </div>
        <div class="photo">
          <a href="/admin/photos?id_photo=<?= $comment['id_photo'] ?>">Перейти до фото</a>
        </div>

      </div>
      <div class="col-xs-3">
        <button class="col-xs-12 btn-default btn mark_comment" data-status="2" data-id="<?= $comment['id'] ?>">&checkmark;</button>
        <button class="col-xs-12 btn-danger btn mark_comment" data-status="-1" data-id="<?= $comment['id'] ?>">&times;</button>
      </div>
    </div>
  </div>
<? } ?>
