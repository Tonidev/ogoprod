<?php
/**
 * Created by PhpStorm.
 * User: shikon
 * Date: 30.03.17
 * Time: 2:20
 */
if(!defined('BASE_DIR')) {
  define('BASE_DIR', __DIR__ .DIRECTORY_SEPARATOR);
}
include(BASE_DIR .'config.php');

$name = empty($_REQUEST['name']) ? null : $_REQUEST['name'];
$code = empty($_REQUEST['code']) ? null : mb_strtoupper($_REQUEST['code']);
$vk_id = empty($_REQUEST['vk_id']) ? '' : $_REQUEST['vk_id'];
$email = empty($_REQUEST['email']) ? null : $_REQUEST['email'];
$phone = empty($_REQUEST['phone']) ? '' : $_REQUEST['phone'];
$ip = Helpers::get_client_ip();

$func = empty($_REQUEST['func']) ? null : $_REQUEST['func'];
if (!empty($func)) {
  if(!empty($_REQUEST['ajax'])) {
    switch ($func) {
      case 'checkCodeServices':
        if(!$code) {
          Helpers::jsonOk('OK', array(
                  'all' => true
              )
          );
        } else {
          $service_key = $code[Config::$SERVICE_POSITION];
          if(!empty(Config::$PROMO_SERVICES[$service_key]) ) {
            $promo_service  = Config::$PROMO_SERVICES[$service_key];
            $promo_service['id'] = $service_key;
            Helpers::jsonOk('OK', array(
                    'all' => false,
                    'services' => array($promo_service)
                )
            );
          } else {
            Helpers::jsonOk('OK', array(
                    'all' => false,
                    'services' => false
                )
            );
          }
        }
        break;

      case 'add_order':
        if(
            $name &&
            (!empty($phone) || !empty($vk_id))
        ) {
          if(empty($code)) {
            $code = '____' . date('d-m-Y H:i:s');
          }
          $activated = 1;
          $status = 1;
          $paid = 0;
          $result = Db::i()->query("INSERT INTO ogoprod.promo_code(code, email, phone, `name`, activated, paid, vk_id, status, ip) VALUES (?s, ?s, ?s, ?s, ?i, ?i, ?s, ?i, ?s)", $code, $email, $phone, $name, $activated, $paid, $vk_id, $status, $ip);
          if(!empty($result) ) {
            Helpers::jsonOk("Заявка успешно отправлена");
          } else {
            Helpers::jsonError("Ошибка при отправке заявки");
          }
        } else {
          Helpers::jsonError("Не указаны контактные данные");
        }
        break;
    }
    die();
  }
}
?>
<html>
<body>
<form>
<input name="ajax" value="ajax">
<input name="name" value="name">
<input name="email" value="email">
<input name="phone" value="phone">
<input name="code" value="code">
<input name="vk_id" value="vk_id">
<input name="func" placeholder="add_order" value="checkCodeServices">
<button type="submit">OK</button>
</form>
</body>
</html>

