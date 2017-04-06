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
<? include ('header.php');?>
<head>
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
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

<? include ('left_menu.php'); ?>

<div class="content">

    <div class="port_block">


            <div class="port_album">
                <div class="port_photo">
                    <img class="port_img" src="img/VAD.jpg">
                    <div class="port-line"><span class="port-text">Вадим Оголяр</span></div>
                </div>
            </div>

            <div class="port_album">
                <div class="port_photo">
                    <img class="port_img" src="img/AR.jpg">
                    <div class="port-line"><span class="port-text">Арчил Сванидзе</span></div>
                </div>
            </div>

<!--      TODO make protfolio albums-->
<div class="port1">
    <div><img  src="albums/1/OGO_8896.jpg"></div>
    <div><img src="albums/1/OGO_8896.jpg"></div>
    <div><img src="albums/1/OGO_8896.jpg"></div>
    <div><img src="albums/1/OGO_8896.jpg"></div>
    <div><img src="albums/1/OGO_8896.jpg"></div>
    <div><img src="albums/1/OGO_8896.jpg"></div>
    <div><img src="albums/1/OGO_8896.jpg"></div>
    <div><img src="albums/1/OGO_8896.jpg"></div>
    <div><img src="albums/1/OGO_8896.jpg"></div>
    <div><img src="albums/1/OGO_8896.jpg"></div>
</div>

</div>

<script type="text/javascript">
  $('.port1').slick({
    centerMode: true,
    centerPadding: '60px',
    slidesToShow: 1,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: false,
          centerMode: true,
          centerPadding: '40px',
          slidesToShow: 3
        }
      },
      {
        breakpoint: 480,
        settings: {
          arrows: false,
          centerMode: true,
          centerPadding: '40px',
          slidesToShow: 1
        }
      }
    ]
  });
    $('.port2').slick({
        centerMode: true,
        centerPadding: '60px',
        slidesToShow: 1,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 1
                }
            }
        ]
    });
    appid = 5941079;
    VK.init({
        apiId: appid
    });
</script>
<script src="/js/startscr.js"></script>
</body>

</html>
