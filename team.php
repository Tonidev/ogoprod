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
<head>

    <? include ("header.php");?>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body class="main">
<? if(empty($_SESSION['no_index']) || (time() - $_SESSION['no_index']) > 60*60*24) { ?>
<? }
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
    <div id="teamblock">
    <div style="width: 240px; padding-right: 20px;">
    <img style="width:100%; border-radius: 50px;" src="img/team/vad-mini.jpg">
    <p style="text-align: center;font-family: PNG1;font-size: 23px; color: white;position: relative;top: -18px;">Вадим Оголяр</p>
    </div>
    <span style="padding-left:15px;font-family: PNG1;font-size: 18px;color: white;position: relative;top: -28px;">
        <h3>Керівник студії. Викладач Elementary та Дитячого курсу</h3>
<ul>
<li>Питання по співпраці</li>
<li>Взаємодія зі спонсорами і партнерами</li>
<li>Прийом на работу фотографів</li>
<li>Контроль над якісттю</li>
<li>Робота з моделями</li>
<li>Студійна та рекламна зйомка</li>
<li>Ютюб відео-зйомка</li>
</ul>

    </span>
    </div>
<p></p>
    <div id="teamblock">
        <div style="width: 240px; padding-right: 20px;">
            <img style="width:100%; border-radius: 50px;" src="img/team/arch-mini.jpg">
            <p style="text-align: center;font-family: PNG1;font-size: 23px; color: white;position: relative;top: -18px;">Арчил Сванидзе</p>
        </div>
    <span style="padding-left:15px;font-family: PNG1;font-size: 18px;color: white;position: relative;top: -28px;">
<h3>Фотограф та відеограф. Викладач Advance курс та курсів ретушуванню.</h3>
<li>Свадебна та сімейна зйомка</li>
<li>Рекламна відео-зйомка</li>
<li>Приватні уроки</li>

    </span>
    </div>

    <div id="teamblock">
        <div style="width: 240px; padding-right: 20px;">
            <img style="width:100%; border-radius: 50px;" src="img/team/anna-mini.jpg">
            <p style="text-align: center;font-family: PNG1;font-size: 23px; color: white;position: relative;top: -18px;">Анна Vie</p>
        </div>
    <span style="padding-left:15px;font-family: PNG1;font-size: 18px;color: white;position: relative;top: -28px;">
<h3>Адміністратор.</h3>
<li>Прийом заказів</li>
<li>Питання стосовно реклами</li>
<li>Розміщення матеріалу на сайті</li>

    </span>
    </div>

    </div>

<div id="photo_popup"  data-image="">
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
        return '<img class="social" src="img/soc-vk.png"/><img class="social" src="img/soc-facebook.png"/><img class="social" src="img/soc-instagram.png"/><div><a onclick="entermain(); return false;" class="button1" style="margin-right: 19%;">ВХОД</a></div>';
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


</script>
<? include 'footer.php'; ?>
</body>
</html>
