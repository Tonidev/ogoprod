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

$photos = $db->getAll("SELECT * FROM  photo WHERE status > 0");
$comments = $db->getAll("SELECT * FROM  comment WHERE status > 0");
?>
<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript">
        function proverka(tel) {
            tel.value = tel.value.replace(/[^\d ]/g, '');
        }
    </script>
    <meta name="charset" content="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Title</title>
    <!--  <link rel="stylesheet" href="css/style.css">-->
    <script src="js/jq.js"></script>
    <script src="js/core.js"></script>
    <script src="js/touch.js"></script>
    <script src="js/dropdown.js"></script>
    <link rel="stylesheet" href="css/dropdown.css"/>
    <script src="js/sweetalert.min.js"></script>

    <link rel="stylesheet" href="css/sweetalert.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://vk.com/js/api/openapi.js?142" type="text/javascript"></script>
</head>
<body class="main">
<script>
    jQuery("document").ready(function($) {
        $('select').dropdown({});
    });
</script>

<div class="logo">
    <a href="/"></a>
</div>
<div class="left-menu">
    <ul>

        <li><a class="main" href="main.php"><span class="ico"></span><span class="text">главная</span></a></li>
        <li><a class="portfolio" href="main.php"><span class="ico"></span><span class="text">порфолио</span></a></li>
        <li><a class="services" href="price.php"><span class="ico"></span><span class="text">услуги</span></a></li>
        <li><a class="gallery" href="main.php"><span class="ico"></span><span class="text">альбомы</span></a></li>
    </ul>
</div>
<div class="content">
    <div class="album">
        <div class="albumini">
                    <div class="mini-img" style="background-image: url('albums/1/OGO_4182.jpg');"></div>
                    <div class="mini-img" style="background-image: url('albums/1/OGO_4044.jpg');"></div>
            <div class="mini-img" style="background-image: url('albums/1/OGO_4182.jpg');"></div>
            <div class="mini-img" style="background-image: url('albums/1/OGO_4044.jpg');"></div>
            <div class="mini-img" style="background-image: url('albums/1/OGO_4182.jpg');"></div>
            <div class="mini-img" style="background-image: url('albums/1/OGO_4044.jpg');"></div>
            <div class="mini-img" style="background-image: url('albums/1/OGO_4182.jpg');"></div>
            <div class="mini-img" style="background-image: url('albums/1/OGO_4044.jpg');"></div>
            <div class="mini-img" style="background-image: url('albums/1/OGO_4182.jpg');"></div>
            <div class="mini-img" style="background-image: url('albums/1/OGO_4044.jpg');"></div>
            </div>
        </div>

    </div>
</div>
<!--
<footer>

</footer>
-->
<script type="text/javascript">
    appid = 5941079;
    VK.init({
        apiId: appid
    });
</script>
<script src="/js/startscr.js"></script>
</body>

</html>
v