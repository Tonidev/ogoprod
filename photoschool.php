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
<head>
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

<div style="text-align: center; width: 90%;">
    <img style="border-radius: 30px;width: 65%;" src="img/photoschool/DSC_0681.jpg">
</div>

    <span style="font-family: PNG1;font-size: 18px;color: white;">

        <h3>Фотошкола oGo production запрошує на наступні напрями навчання:</h3>


<h3 style="text-shadow: rgba(8,204,171,1) 0 0 10px;">Advance курс</h3>

Безліч студій чи то самих фотографів пропонують вам навчитися мистецтву фотографії, але перш за все їх головним завданням залишається заробіток грошей, при цьому їх не хвилює ваше професійне зростання.
Ми зацікавлені в тому, щоб поповнити нашу команду справді талановитими людьми і створили для них Advance курс навчання. Це:

<li>Цікава авторська програма
<li>Різноманітні види фотозйомки
<li>Практичні уроки в oGo production і не тільки
<li>Покращення навичок ретушування
<li>Групи до 10 чоловік, кожен учень отримує достатньо уваги
<li>Команда вчителів - досвідчених фотографів із різними стилями фотозйомки
<li>Запрошені вузьконаправлені фотографи з власними унікальними програмами
<li>Можливе подальше працевлаштування
</span>
    <p></p>
            <a href="#" class="totton"/>Повний опис</a>
    <p></p>
<span style="font-family: PNG1;font-size: 18px;color: white;">
            <h3 style="text-shadow: rgba(8,204,171,1) 0 0 10px;">Elementary курс</h3>

Хоча маркетологи і кажуть що "авто" режим зможе більше, ніж людина, але це, звісно, не так.
Якщо ви бажаєте вміти більше, ніж просто натискати на кнопку, втілити свої творчі ідеї в життя, не плануєте стати фотографом, тим не менш, маєте бажання навчитись фотографувати, то наш Elementary курс - саме для вас.
В программі курсу:
<li>Знайомство з камерою
<li>Два блоки навчання
<li>Цікава і зрозуміла подача інформації для новачків від провідних фотографів міста
<li>Практичні уроки в oGo production і не тільки
<li>Групи до 10 чоловік, кожен учень отримує достатньо уваги
</span>
    <p></p>
    <a href="#" class="totton"/>Повний опис</a>
    <p></p>
<span style="font-family: PNG1;font-size: 18px;color: white;">
        <h3 style="text-shadow: rgba(8,204,171,1) 0 0 10px;">Курс ретушування Light</h3>

Маєш гарні кадри, але ти не знаешь що з ними робити після експорту? Ти десь чув про слова Lightroom та Photoshop, але не вмієш працювати з цими програмами, тоді до твоєї уваги уроки ретушування, курс Light:

<li>Корекціякольору
<li>Швидке ретушування знімку
<li>Теоретичні знання
            </span>
    <p></p>
    <a href="#" class="totton"/>Повний опис</a>
    <p></p>
<span style="font-family: PNG1;font-size: 18px;color: white;">
        <h3 style="text-shadow: rgba(8,204,171,1) 0 0 10px;">Курс ретушування Pro</h3>

Ти вже досить досвідчений фотограф, але твоя ретуш тобі не подобається? Завдяки курсу ретушування Pro твої кадри будуть якісно відрізнятися від фотографій інших. Ми розкриємо вам усі секрети.

<li>Журнальная ретуш
<li>Основи компоузингу
            </span>
    <p></p>
    <a href="#" class="totton"/>Повний опис</a>
    <p></p>
<span style="font-family: PNG1;font-size: 18px;color: white;">

        <h3 style="text-shadow: rgba(8,204,171,1) 0 0 10px;">Дитяча фотошкола (10-16 років)</h3>

Батьки завжди бажають для своєї дитини найкращого, саме тому ми відкрили курс дитячої фотографіі, де ваша дитина навчиться як теоретичним , так і практичним знанням роботи з камерою

<li>Знайомство з камерою
<li>Розкриття творчого потенціалу
<li>Невеликі групи до 5 дітей
<li>Уважні педагоги
<li>Практичні заняття
            </span>
    <p></p>
            <a href="#" class="totton"/>Повний опис</a>
    <p></p>
<span style="font-family: PNG1;font-size: 18px;color: white;">
<p>По закінченню курсів видається диплом.</p>

    </span>
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
