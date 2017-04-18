<?php

use claviska\SimpleImage;
require_once (BASE_DIR. 'SimpleImage.php');

$errors = array();

$blog_album = Db::i()->getRow("SELECT * FROM album WHERE status = " . Config::$ALBUM_STATUS_BLOG);


if(empty($blog_album)) {
  echo '<p class="alert alert-danger">Не створено альбому для блога</p>';
  return;
}

$album_id = $blog_album['id'];


if(!empty($_REQUEST['func']) ) {
  switch ($_REQUEST['func']) {
    case 'add':
      $post = array(
          'id' =>'',
          'title' => empty($_REQUEST['title']) ? '' : $_REQUEST['title'],
          'description' => empty($_REQUEST['description']) ? '' : $_REQUEST['description'],
          'chpu' => empty($_REQUEST['chpu']) ? '' : $_REQUEST['chpu'],
          'author' => empty($_REQUEST['author']) ? Config::$DEFAULT_AUTHOR : $_REQUEST['author'],
          'content' => empty($_REQUEST['content']) ? '' : $_REQUEST['content'],
          'status' => empty($_REQUEST['status']) ? 0 : $_REQUEST['status'],
          'url' => empty($_REQUEST['url']) ? '' : $_REQUEST['url'],
          'url_mini' => empty($_REQUEST['url_mini']) ? '' : $_REQUEST['url_mini']
      );
      if(!empty($_REQUEST['submit'])) {

        if(empty($post['title'])) {
          $errors[]= 'Не вказаний заголовок';
        }


        if(empty($post['chpu'])) {
          $errors[]= 'Не вказаний URL';
        }


        if(empty($post['content'])) {
          $errors[]= 'Не вказаний контент';
        }
        $id_photo = 0;
        $id_album = $album_id;
        $description = empty($_POST['description']) ? '' : $_POST['description'];
        $name = empty($_POST['name']) ? 'new' : $_POST['name'];
        $status = 1;
        foreach($_FILES as $fs) {
          if(empty($fs['name']) || (is_array($fs['name']) && empty($fs['name'][0]) ) ) {
            continue;
          }
          foreach ($fs as $k => $v) {
            if(!is_array($fs[$k])) {
              $fs[$k] = array($v);
            }
          }
          $fscount = count($fs['name']);
          for ($i = 0; $i < $fscount; $i++) {
            $type = mb_strtolower(mb_substr(mb_strrchr($fs['name'][$i], '.'), 1));
            $name = empty($_POST['name']) ? 'new' : $_POST['name'];
            $imagesize = @getimagesize($fs['tmp_name'][$i]);
            if (
                !empty($fs['tmp_name'][$i]) &&
                !empty($imagesize) &&
                in_array(
                    strtolower(substr(strrchr($imagesize['mime'], '/'), 1)), array(
                        'jpg',
                        'gif',
                        'jpeg',
                        'png'
                    )
                ) &&
                in_array($type, array('jpg', 'gif', 'jpeg', 'png'))
            )
            {
              $dir_name = BASE_PHOTO_PATH . $id_album . DIRECTORY_SEPARATOR;
              if(!is_dir($dir_name)) {
                mkdir($dir_name, 0777, true);
              }

              $upload_url = BASE_PHOTO_URL . $id_album . '/';
              $upload_mini_url = BASE_PHOTO_URL . $id_album . '/';
              $upload_path = $dir_name . $name . '.' . $type;

              if (!$upload_path  || !move_uploaded_file($fs['tmp_name'][$i], $upload_path )) {
                Helpers::jsonError('An error occurred during the image upload process.');
                die;
              }
              if(!Db::i()->query("INSERT INTO photo (id_album, description, `status`) VALUES (?i, ?s, ?i)", $id_album, $description, $status) ) {
                Helpers::jsonError("Невозможно добавить фото в базу");
                die();
              }

              $id_photo = Db::i()->insertId();
              $final_path = $dir_name . $id_photo . '.' . $type;
              $final_mini_path = $dir_name . $id_photo . '.min.' . $type;
              rename($upload_path, $final_path);

              $yOffset =null;
              $xOffset =null;

              $mini = new SimpleImage();
              $mini->fromFile($final_path);
              $mini->resize('1024');
              if ($id_album) {
                $mini->overlay(Config::$WATERMARK_FILE, Config::$WATERMARK_POSITION, Config::$WATERMARK_OPACITY, $xOffset, $yOffset );
              }
              $mini->toFile($final_mini_path);

              if($id_album) {
                $watermarked = new SimpleImage();
                $watermarked->fromFile($final_path);
                $watermarked->overlay(Config::$WATERMARK_FILE, Config::$WATERMARK_POSITION, Config::$WATERMARK_OPACITY, $xOffset, $yOffset );
                $watermarked->toFile($final_path);
              }



              $upload_url .= $id_photo.'.'.$type;
              $upload_mini_url .= $id_photo . '.min.' . $type;
              $upload_url = preg_replace('@/+@', '/', $upload_url);
              $upload_mini_url = preg_replace('@/+@', '/', $upload_mini_url);

              if(!Db::i()->query("UPDATE photo SET url = ?s, url_mini = ?s WHERE id = ?i", $upload_url, $upload_mini_url, $id_photo )) {
                Helpers::jsonError("Невозможно добавить фото в базу");
                die;
              }
            } else {
              Helpers::jsonError('Можно загрузить фото только с расширением jpg, gif, jpeg или png');
              die;
            }
          }
        }
        $inserted = Db::i()->query("
INSERT INTO post 
(title, description, author, status, content, id_photo, chpu) 
VALUES 
( ?s, ?s, ?s, ?i, ?s, ?i, ?s )",
            $post['title'],
            $post['description'],
            Config::$DEFAULT_AUTHOR,
            $post['status'],
            $post['content'],
            $id_photo,
            $post['chpu']);
        if($inserted) {
          $pid = Db::i()->insertId();
//          $post['id'] = $pid;
          if(empty($_REQUEST['getResultData'])) {
            Helpers::redirect('/admin/post/'.$pid);
          }
        } else {
          $errors[] = 'Неможливо додати запис, перевірте правильність полів';
        }
        break;
      }
      break;
  }
} else {
  if(empty($_REQUEST['id'])) {
    Helpers::redirect('/blog');
  } else {
    $id = intval($_REQUEST['id']);
    $post = Db::i()->getRow("
SELECT p.* , ph.url, ph.url_mini
FROM post p 
LEFT JOIN  photo ph
ON ph.id = p.id_photo
WHERE p.id = $id ");
    if(empty($post)) {
      http_response_code(404);
    }
  }
}
?>
<? if(empty($post['id'])) { ?>
    <h1>Додати запис</h1>
<? } else { ?>
  <h1>Редагувати запис</h1>
<? } ?>
<? if(!empty($errors)) { ?>
    <div class="col-xs-12 panel">
      <div class="page-header alert alert-danger">
        <?= join('<br/>', $errors) ?>
      </div>
    </div>
<? } ?>

<div class="panel col-md-3 col-xs-12  pull-right">
  <div class="panel-body">
    <form action="/admin/photo" id="ajax_image_upload_form" enctype="multipart/form-data" method="post">
      <input name="id_album" type="hidden" value="<?= $album_id ?>">
      <input name="status" type="hidden" value="1">
      <input name="func" type="hidden" value="addPhoto">
      <input name="getResultData" type="hidden" value="1">
      <input name="ajax" type="hidden" value="ajax">

      <label for="ajax_upload">Завантажити фото на сервер</label>
      <input class="" name="photo" type="file" id="ajax_upload">
      <button class="btn-default btn" type="submit">Завантажити!</button>
    </form>
  </div>
</div>


<form method="post" id="post_form" enctype="multipart/form-data">
  <div class="col-xs-12 col-md-9 post panel">
    <div class="panel-heading post_title translit">
      <input class="form-control" data-target="chpu" name="title" value="<?= $post['title'] ?>" placeholder="Заголовок">
      <input class="form-control" data-source="title" name="chpu" value="<?= $post['chpu'] ?>" placeholder="URL">
    </div>
    <div class="panel-body">
      <div class="post_photo" style="background-image: url('<?= empty($post['url_mini']) ? $post['url'] : $post['url_mini'] ?>')">
      </div>
      <div>
        <label for="photo">Завантажити обкладинку</label>
        <input type="file" id="photo" name="photo">
        <input type="hidden" name="id_album" value="<?= $album_id ?>">
      </div>
      <div class="post_description">
        <label for="description">Опис</label>
        <textarea class="form-control" id="description" name="description" maxlength="255"><?= $post['description'] ?></textarea>
      </div>
      <div class="post_content">
        <label for="content">Текст статті</label>
        <textarea class="tinymce" id="content" name="content"><?= $post['content'] ?></textarea>
      </div>
    </div>
    <div class="panel-footer">
        <select class="form-control" name="status">
          <option value="1"> Опубліковано</option>
          <option value="0" <? if(empty($post['status'])) { ?> selected <? } ?> >Не опубліковано</option>
        </select>
    </div>
    <div class="panel-footer post_actions">
      <? if(!empty($post['id'])) { ?>
        <a href="/admin/post/<?= $post['id'] ?>" class="btn btn-default edit">Редагувати</a>
        <button class="btn btn-danger delete">Видалити</button>
      <? } else { ?>
        <button name="submit" value="1" type="submit" class="btn btn-danger add">Додати</button>
      <? } ?>
    </div>
  </div>
</form>


<script type="text/javascript">
  $('#post_form').submit(function(e) {
    var $this = $(this);
    $this.find('.tinymce').tinymce().save();
  } );
</script>
