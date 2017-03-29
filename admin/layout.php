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
</head>
<body class="<?= $action ?>">
<?php
include ('header.php');
?>
<div id="content" class="container-fluid">
  <?
  echo empty($admin_content) ? '' : $admin_content;
  ?>
</div>

<?php
include ('footer.php');
?>
</body>
</html>
