<?php
/**
 * Created by PhpStorm.
 * User: shikon
 * Date: 29.03.17
 * Time: 6:50
 */
/** @var string $action */
/** @var string $admin_content */
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta title="OGOPROD Admin">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="/css/sweetalert.css">
  <link rel="stylesheet" href="/css/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/css/bootstrap/css/bootstrap-theme.css">
  <link rel="stylesheet" href="/css/admin.css">

<!--  <link rel="stylesheet" href="/css/style.css">-->

  <script type="text/javascript" src="/css/bootstrap/js/jquery-1.12.4.js"></script>
  <script type="text/javascript" src="/css/bootstrap/js/bootstrap.js"></script>
  <script type="text/javascript" src="/js/sweetalert.min.js"></script>
  <script type="text/javascript" src="/js/liTranslit/jquery.liTranslit.js"></script>
  <script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
  <script type="text/javascript" src="/js/admin.js"></script>
</head>
<body class="<?= $action ?>">
<?php
include (ADMIN_DIR . 'header.php');
?>
<div id="content" class="col-sm-9 col-sm-offset-3
col-md-10 col-md-offset-2
col-lg-11 col-lg-offset-1
<?= $action ?>">
  <?
  echo empty($admin_content) ? '' : $admin_content;
  ?>
</div>

<?php
include (ADMIN_DIR . 'footer.php');
?>
</body>
</html>
