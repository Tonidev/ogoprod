<?php
/**
 * Date: 13.03.17
 * Time: 18:47
 */

if (!defined('BASE_DIR')) {
  define('BASE_DIR', __DIR__ . DIRECTORY_SEPARATOR);
}
require_once(BASE_DIR . 'config.php');

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
<? include("header.php"); ?>
<body class="main">
<? if (empty($_SESSION['no_index']) || (time() - $_SESSION['no_index']) > 60 * 60 * 24) { ?>
<? }
$_SESSION['no_index'] = time();
?>

<DIV id="logobg">
  <div id="logotmp">
    <div id="start" width="2000" height="1200"></div>
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
  <a data-usluga="photo-usluga5" href="#" class="totton">Повний опис</a>
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
  <a data-usluga="photo-usluga4" href="#" class="totton">Повний опис</a>
  <p></p>
  <span style="font-family: PNG1;font-size: 18px;color: white;">
        <h3 style="text-shadow: rgba(8,204,171,1) 0 0 10px;">Курс ретушування Light</h3>

Маєш гарні кадри, але ти не знаешь що з ними робити після експорту? Ти десь чув про слова Lightroom та Photoshop, але не вмієш працювати з цими програмами, тоді до твоєї уваги уроки ретушування, курс Light:

<li>Корекціякольору
<li>Швидке ретушування знімку
<li>Теоретичні знання
            </span>
  <p></p>
    <span style="text-shadow: rgba(0, 178, 93, 0.9) 0 0 10px;"> Уточнувати повний опис за телефоном</span>
  <p></p>
  <span style="font-family: PNG1;font-size: 18px;color: white;">
        <h3 style="text-shadow: rgba(8,204,171,1) 0 0 10px;">Курс ретушування Pro</h3>

Ти вже досить досвідчений фотограф, але твоя ретуш тобі не подобається? Завдяки курсу ретушування Pro твої кадри будуть якісно відрізнятися від фотографій інших. Ми розкриємо вам усі секрети.

<li>Журнальная ретуш
<li>Основи компоузингу
            </span>
  <p></p>
<span style="text-shadow: rgba(0, 178, 93, 0.9) 0 0 10px;"> Уточнувати повний опис за телефоном</span>
  <p></p>
  <span style="font-family: PNG1;font-size: 18px;color: white;">

        <h3 style="text-shadow: rgba(8,204,171,1) 0 0 10px;">Дитяча фотошкола (10-16 років)</h3>

Батьки завжди бажають для своєї дитини найкращого, саме тому ми відкрили курс дитячої фотографіі, де ваша дитина навчиться як теоретичним , так і практичним знанням роботи з камерою

    <li>Знайомство з камерою</li>
    <li>Розкриття творчого потенціалу</li>
    <li>Невеликі групи до 5 дітей</li>
    <li>Уважні педагоги</li>
    <li>Практичні заняття</li>
            </span>
  <p></p>
    <span style="text-shadow: rgba(0, 178, 93, 0.9) 0 0 10px;font-family: PNG1;font-size: 18px;color: white;"> Уточнувати повний опис за телефоном</span>
  <p></p>
  <span style="font-family: PNG1;font-size: 18px;color: white;">
<p>По закінченню курсів видається диплом.</p>

    </span>
</div>

<? include(BASE_DIR . 'photo_popup.php') ?>

<div id="photo-usluga5" class="overlay" style="">
    <div class="popup kurs" style="top:10%;">
        <h2 style="text-align: center; color:white">Advance курс</h2>

    <div class="schoolblock" style="height:110px"><span><a
            style="padding-bottom: 1em;padding-left:2.3em;font-size: 18px;text-shadow: rgba(8,204,171,2) 0 0 10px;"
            onclick="return false;">INTRODUCTION. WEEK NO. 1 </a>

        <br>&nbsp;<a onclick="return false;" style="padding-top:2em ">Знайомство. Вступний практичний урок. </a>
    <br>&nbsp;Тест на рівень професійності.
    <br>&nbsp;Індивідуальна робота з учнями.
            </span></div>
    <div class="schoolblock" style="height:110px"><span><a
            style="padding-left:5.3em;font-size: 18px;text-shadow: rgba(8,204,171,2) 0 0 10px;" onclick="return false;">WEEK NO. 2 </a>
<br>&nbsp;Схеми розташування світла. Свiтлотiнь.
<br>&nbsp;Курс роботи зі студійним освітленням
<br>&nbsp;Логіка замовника. Ракурси у фотографії.
<br>&nbsp;Золотий перетин і його використання.
<br>&nbsp;Види зйомок, розподіл по жанрах, вибір  &nbsp;потрібного обладнання
</span></div>
    <div class="schoolblock" style="height:110px"> <span><a
            style="padding-left:5.3em;font-size: 18px;text-shadow: rgba(8,204,171,2) 0 0 10px;" onclick="return false;">WEEK NO. 3</a>
        <br>&nbsp;Використання на практиці отриманих знань
                      <br>&nbsp;Відшліфування навичок
                      <br>&nbsp;Студійна зйомок. Beauty-зйомка
                      <br>&nbsp;Лав сторі. Зйомка за містом
                      <br>&nbsp;Особливості весільної зйомки
                      <br>&nbsp;Предметна зйомка для каталогу.
                </span></div>
    <div class="schoolblock" style="height:110px"><span><a
            style="padding-left:5.3em;font-size: 18px;text-shadow: rgba(8,204,171,2) 0 0 10px;" onclick="return false;">WEEK NO. 4</a>
                    <br>&nbsp;Весільна зйомка. Практичний урок
                    <br>&nbsp;Зйомка для магазину одягу
                    <br>&nbsp;Зйомка на виїзді
                    <br>&nbsp;Зйомка білизни</span></div>


    <button class="close" title="Закрыть" ></button>
    <div>
    </div>
  </div>
</div>


    <div id="photo-usluga4" class="overlay" style="">
        <div class="popup kurs" style="top:10%;">
            <h2 style="text-align: center; color:white;">Elementary курс</h2>

            <div class="schoolblock"><span><a style="padding-bottom: 1em;padding-left:5.3em;font-size: 18px;text-shadow: rgba(8,204,171,2) 0 0 10px;" onclick="return false;">Заняття №1</a>
        <br>&nbsp;<a onclick="return false;" style="padding-top:2em ">- Принципи використання фотокамери</a>
        <br>&nbsp;- Особливості режимів зйомки
        <br>&nbsp;- Crop factor
        <br>&nbsp;- Основні поняття про мануальний режим
        <br>&nbsp;- Чому треба знімати в Raw
            </span></div>
            <div class="schoolblock"><span>
           <a style="padding-left:5.3em;font-size: 18px;text-shadow: rgba(8,204,171,2) 0 0 10px;" onclick="return false;">Заняття №2</a>
        <br>&nbsp;- ISO
        <br>&nbsp;- Витримка
        <br>&nbsp;- Apertura
        <br>&nbsp;- Експозиція та робота з гістограмою
        <br>&nbsp;- Фокусна відстань об'єктивів</span></div>
            <div class="schoolblock"><span><a style="padding-left:5.3em;font-size: 18px;text-shadow: rgba(8,204,171,2) 0 0 10px;" onclick="return false;">Заняття №3</a>
        <br>&nbsp;- Фокусування
        <br>&nbsp;- Глибина різкості
        <br>&nbsp;- Практика</span></div>
            <div class="schoolblock"><span><a style="padding-left:5.3em;font-size: 18px;text-shadow: rgba(8,204,171,2) 0 0 10px;" onclick="return false;">Заняття №4</a>
        <br>&nbsp;- Робота з витримкою
        <br>&nbsp;- Практика на вулиці</span></div>
            <div class="schoolblock"><span><a style="padding-left:5.3em;font-size: 18px;text-shadow: rgba(8,204,171,2) 0 0 10px;" onclick="return false;">Заняття №5</a>
        <br>&nbsp;- White balance
        <br>&nbsp;- Кращі кольори сприйняття людським оком
        <br>&nbsp;- Знайомство з Лайтрумом</span></div>
            <div class="schoolblock"><span><a style="padding-left:5.3em;font-size: 18px;text-shadow: rgba(8,204,171,2) 0 0 10px;" onclick="return false;">Заняття №6</a>
        <br>&nbsp;- Вертикальне або горизонтальне фото
        <br>&nbsp;- Правило третин
        <br>&nbsp;- Можливості передачи простору та руху, статики та динамикі
        <br>&nbsp;- Емоції в кадрі
        <br>&nbsp;- Практика</span></div>
            <div class="schoolblock"> <span><a style="padding-left:5.3em;font-size: 18px;text-shadow: rgba(8,204,171,2) 0 0 10px;" onclick="return false;">Заняття №7</a>
        <br>&nbsp;- Знайомство зі студійним світлом
        <br>&nbsp;- Особливості зйомки у студії
        <br>&nbsp;- Практика + д/з</span></div>
            <div class="schoolblock"><span><a style="padding-left:5.3em;font-size: 18px;text-shadow: rgba(8,204,171,2) 0 0 10px;" onclick="return false;">Заняття №8</a>
        <br>&nbsp;- Аналіз робіт учасників
        <br>&nbsp;- Закріплення матеріалу
        <br>&nbsp;- Відповіді на запитання</span></div>

    <button class="close" title="Закрыть"></button>
    <div>
    </div>
  </div>
</div>


<? include 'footer.php'; ?>

</body>
</html>
