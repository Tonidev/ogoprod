<?php
/**
 * Created by PhpStorm.
 * User: shikon
 * Date: 30.03.17
 * Time: 17:14
 */

use claviska\SimpleImage;
require_once (BASE_DIR. 'SimpleImage.php');
$func = empty($_REQUEST['func']) ? null : $_REQUEST['func'];
if (!empty($func)) {
  if(!empty($_REQUEST['ajax'])) {
    switch ($func) {
      case 'addPhoto' :
        $url = empty($_POST['url']) ? '' : $_POST['url'];
        $id_album = empty($_POST['id_album']) ? 0 : intval($_POST['id_album']);
        $description = empty($_POST['description']) ? '' : $_POST['description'];
        $name = empty($_POST['name']) ? 'new' : $_POST['name'];
        $status = empty($_POST['status']) ? 0 : 1;
        $urls = preg_split('/\s+/',$url);
        foreach ($urls as $url) {
          if(!empty($url)) {
            $type = mb_strtolower(mb_substr(mb_strrchr($url, '.'), 1));
            if(in_array($type, array('jpg', 'gif', 'jpeg', 'png'))) {
              $curl = curl_init();
              curl_setopt($curl, CURLOPT_URL, $url);
              curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($curl, CURLOPT_HEADER, false);
              $data = curl_exec($curl);
              curl_close($curl);
              $content = $data;

              if(empty($content)) {
                Helpers::jsonError('An error occurred during the image copy process.');
                die;
              }

              $dir_name = BASE_PHOTO_PATH . $id_album . DIRECTORY_SEPARATOR;
              if(!is_dir($dir_name)) {
                mkdir($dir_name, 0777, true);
              }

              $upload_url = BASE_PHOTO_URL . $id_album . '/';
              $upload_mini_url = BASE_PHOTO_URL . $id_album . '/';
              $upload_path = $dir_name . $name . '.' . $type;

              try {
                $fp = fopen($upload_path, "w");
                fwrite($fp, $content);
                fclose($fp);

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

                if($id_album) {
                  $watermarked = new SimpleImage();
                  $watermarked->fromFile($final_path);
                  $watermarked->overlay(Config::$WATERMARK_FILE, Config::$WATERMARK_POSITION, Config::$WATERMARK_OPACITY, $xOffset, $yOffset );
                  $watermarked->toFile($final_path);
                }

                $mini = new SimpleImage();
                $mini->fromFile($final_path);
                $mini->resize('1024');
                if($id_album) {
                  $mini->overlay(Config::$WATERMARK_FILE, Config::$WATERMARK_POSITION, Config::$WATERMARK_OPACITY, $xOffset, $yOffset );
                }

                $mini->toFile($final_mini_path);

                $upload_url .= $id_photo . '.' . $type;
                $upload_mini_url .= $id_photo . '.min.' . $type;
                $upload_url = preg_replace('@/+@', '/', $upload_url);
                $upload_mini_url = preg_replace('@/+@', '/', $upload_mini_url);

                if(!Db::i()->query("UPDATE photo SET url = ?s, url_mini = ?s WHERE id = ?i", $upload_url, $upload_mini_url, $id_photo )) {
                  Helpers::jsonError("Невозможно добавить фото в базу");
                  die();
                }
              } catch(Exception $e) {
                Helpers::jsonError("Ошибка: " . $e->getMessage());
                die();
              }
            } else {
              Helpers::jsonError('Можно загрузить фото только с расширением jpg, gif, jpeg или png');
              die;
            }
          }
        }
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

              if($id_album) {
                $watermarked = new SimpleImage();
                $watermarked->fromFile($final_path);
                $watermarked->overlay(Config::$WATERMARK_FILE, Config::$WATERMARK_POSITION, Config::$WATERMARK_OPACITY, $xOffset, $yOffset );
                $watermarked->toFile($final_path);
              }

              $mini = new SimpleImage();
              $mini->fromFile($final_path);
              $mini->resize('1024');
              if ($id_album) {
                $mini->overlay(Config::$WATERMARK_FILE, Config::$WATERMARK_POSITION, Config::$WATERMARK_OPACITY, $xOffset, $yOffset );
              }
              $mini->toFile($final_mini_path);

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
        Helpers::redirect('/admin/photos');
        break;

    }
    die();
  }
}

$photos = Db::i()->getAll("SELECT * FROM photo ORDER BY timestamp");
$albums = Db::i()->getAll("SELECT * FROM album WHERE status >= 0");
?>

<? if(true) { ?>
  <h2 class="page-header toggle_next">Поділитись фотками</h2>
  <div id="add_photo">
    <form method="post" enctype="multipart/form-data">
      <input type="hidden" name="func" value="addPhoto">
      <input type="hidden" name="ajax" value="ajax">
      <div class="form-group">
        <textarea class="form-control" id="url" name="url" placeholder="Ввести список URL звідки завантажувать"></textarea>
      </div>
      <div class="form-group">
        <label for="files">Та / або завантажити з комп'ютера</label>
        <input  id="files" name="files[]" class="form-control" type="file" multiple placeholder="Та / або завантажити з комп'ютера">
      </div>
      <div class="form-group">
        <input type="text" name="description" class="form-control" placeholder="Дескрипшен (один на всіх)">
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label>
            <input type="checkbox" name="status" id="status"  checked="checked"  value="1">
            Опублікувати одразу
          </label>
        </div>
      </div>
      <div class="form-group">
        <label for="id_album">Альбом</label>
        <select class="form-control" name="id_album" id="id_album">
          <option value="0">Без альбому</option>
          <? foreach( $albums as $album) { ?>
            <option value="<?= $album['id'] ?>"><?= $album['name'] ?></option>
          <? } ?>
        </select>
      </div>
      <div class="form-group">
        <button class="btn btn-default" type="submit">Вперед</button>
      </div>
    </form>
  </div>

<? } ?>
<? if(false) { ?>
  <h2 class="page-header toggle_next">Залить фото</h2>
  <div id="add_photo">
    <form>
      <input type="hidden" name="func" value="addPhoto">
      <label for="url">Ввести список URL откуда скачать</label>
      <textarea id="url" name="url"></textarea>
      <p>И / или загрузить с компьютера</p>
      <input type="file" multiple>
      <button type="submit">Вперед</button>
    </form>
  </div>
<? } ?>
