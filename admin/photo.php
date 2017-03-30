<?php
/**
 * Created by PhpStorm.
 * User: shikon
 * Date: 30.03.17
 * Time: 17:14
 */

$func = empty($_REQUEST['func']) ? null : $_REQUEST['func'];
if (!empty($func)) {
  if(!empty($_REQUEST['ajax'])) {
    switch ($func) {
      case 'addPhoto' :
      {
//    http://pngimg.com/uploads/pomegranate/pomegranate_PNG8646.png

        $url = empty($_POST['url']) ? '' : $_POST['url'];
        $id_album = empty($_POST['id_album']) ? 0 : intval($_POST['id_album']);
        $description = empty($_POST['description']) ? '' : $_POST['description'];
        $name = empty($_POST['name']) ? 'new' : $_POST['name'];
        $status = empty($_POST['status']) ? 0 : 1;
        
        if(!empty($url)) {
          $type = mb_strtolower(mb_substr(mb_strrchr($url, '.'), 1));
          if(in_array($type, array('jpg', 'gif', 'jpeg', 'png'))) {

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            $data = curl_exec($curl);
            curl_close($curl);
//          $content = file_get_contents($url);
            $content = $data;

//Store in the filesystem.
            if(empty($content)) {
              Helpers::jsonError($this->l('An error occurred during the image copy process.'));
              die;
            }

            $dir_name = BASE_PHOTO_PATH . $id_album . DIRECTORY_SEPARATOR;
            if(!is_dir($dir_name)) {
              mkdir($dir_name, 0777, true);
            }

            $upload_url = BASE_PHOTO_URL . $id_album . '/';
            $upload_path = $dir_name . $name . $type;

            try {
              $fp = fopen($upload_path, "w");
              fwrite($fp, $content);
              fclose($fp);

              if(!Db::i()->query("INSERT INTO photo (id_album, description, `status`) VALUES (?i, ?s, ?i)", $id_album, $description, $status) ) {
                Helpers::jsonError("Невозможно добавить фото в базу");
                die();
              }

              $id_photo = Db::getInstance()->Insert_ID();


              $upload_url .= $id_photo.$type;
              $upload_mini_url .= $id_photo.$type;

              $upload_url = preg_replace('@/+@', '/', $upload_url);
              $upload_mini_url = preg_replace('@/+@', '/', $upload_mini_url);

              if(Db::i()->query("UPDATE photo SET url = ?s, url_mini = ?s WHERE id = ?i", $upload_url, $upload_mini_url, $id_photo )) {
                Helpers::jsonOk("Фото успешно залито");
                die;
              }
              Helpers::jsonError("Невозможно добавить фото в базу");
            } catch(Exception $e) {
              Helpers::jsonError("Ошибка: " . $e->getMessage());
            }
          } else {
            Helpers::jsonError('Можно загрузить фото только с расширением jpg, gif, jpeg или png');
          }
          die;
        }
        foreach($_FILES as $f) {
          $type = mb_strtolower(mb_substr(mb_strrchr($f['name'], '.'), 1));
          $name = $ingred->name . '.' . $cut->name . '.' . $type;

          $imagesize = @getimagesize($f['tmp_name']);
          if (
              !empty($f['tmp_name']) &&
              !empty($imagesize) &&
              in_array(
                  Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)), array(
                      'jpg',
                      'gif',
                      'jpeg',
                      'png'
                  )
              ) &&
              in_array($type, array('jpg', 'gif', 'jpeg', 'png'))
          )
          {


            $dir_name = YuzuPhoto::getImgDirName();
            $temp_name = $dir_name.$name;

            $path = YuzuPhoto::getBasePath() . DIRECTORY_SEPARATOR . $name ;

            if ($error = ImageManager::validateUpload($f)) {
              $errors[] = $error;
            }
            elseif (!$temp_name || !move_uploaded_file($f['tmp_name'], $path)) {
              Helpers::jsonError($this->l('An error occurred during the image upload process.'));
              die;
            }

            $url = preg_replace('@/+@', '/', _PS_IMG_ . $temp_name);
            $title = $ingred->name . ' ' . $cut->name;

            $existing = Db::getInstance()->query("SELECT * FROM ps_yuzu_photo WHERE `url` = '$url'")->fetch();
            if(!empty($existing)) {
              $id_photo = $existing['id_yuzu_photo'];
            } else {
              $photoQuery = Db::getInstance()->query("INSERT INTO ps_yuzu_photo (url, title) VALUES ('{$url}', '{$title}')") ;
            }
            if(!empty($photoQuery ) || !empty($id_photo) ) {
              $id_photo = empty($id_photo) ? Db::getInstance()->Insert_ID() : $id_photo;

              $existingCut = Db::getInstance()->query("
SELECT * FROM ps_yuzu_ingredient_cut 
WHERE 
  id_ingredient = $idyi AND 
  id_photo = $id_photo AND 
  id_cut = $cid ")->fetch();
              if(!empty($existingCut)) {
                $idyic = $existingCut['id_yuzu_ingredient_cut'];
              } else {
                $inPhotoQuery = Db::getInstance()->query("INSERT INTO ps_yuzu_ingredient_cut(id_ingredient, id_photo, id_cut) VALUES ( $idyi, $id_photo, $cid )");
              }
              if(!empty($inPhotoQuery) || !empty($idyic)) {
                $idyic = empty($idyic) ? Db::getInstance()->Insert_ID() : $idyic;
                Helpers::jsonOk(
                    $this->l('Uploaded successfully'),
                    true,
                    array(
                        'url' => $url,
                        'id_yuzu_ingredient_cut' => $idyic,
                        'name' => $cut->name
                    )
                );
                die;
              }
            }
            Helpers::jsonError($this->l('An error occurred during the image upload process.'));
          }
        }
        Helpers::jsonError($this->l('Image not found or unsupported file extension'));
        die;

      }

        break;
      case 'editPhoto':
        $intParams = array('activated', 'paid', 'status');
        if(!empty($_REQUEST['id']) && !empty($_REQUEST['param']) && isset($_REQUEST['value']) ) {
          $holder = '?s';
          if(in_array($_REQUEST['param'], $intParams)) {
            $holder = '?i';
            if(!is_numeric($_REQUEST['value'])) {
              $_REQUEST['value'] = ($_REQUEST['value'] == 'false' || $_REQUEST['value'] == 'off')
                  ? 0
                  : 1;
            }
          }
          $result = Db::i()->query("UPDATE ogoprod.promo_code SET ?n = $holder WHERE id = ?i", $_REQUEST['param'], intval($_REQUEST['value']), intval($_REQUEST['id']) );
        }
        if(empty($result) ) {
          Helpers::jsonError();
        } else {
          Helpers::jsonOk();
        }
        break;
    }
    die();
  }
}


$photos = Db::i()->getAll("SELECT * FROM photo ORDER BY timestamp");
