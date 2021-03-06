<?php
/**
 * Created by PhpStorm.
 * User: shikon
 * Date: 29.03.17
 * Time: 17:21
 */

//TODO name editable


$func = empty($_REQUEST['func']) ? null : $_REQUEST['func'];
if (!empty($func)) {
  if(!empty($_REQUEST['ajax'])) {
    switch ($func) {
      case 'editPromo':
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
          if($_REQUEST['param'] == 'code') {
            $_REQUEST['value'] = strtoupper($_REQUEST['value']);
          }
          $result = Db::i()->query("
UPDATE promo_code SET ?n = $holder WHERE id = ?i", $_REQUEST['param'], $_REQUEST['value'], intval($_REQUEST['id']) );
        }
        if(empty($result) ) {
          Helpers::jsonError();
        } else {
          Helpers::jsonOk();
        }
        break;
      case 'addPromo':
        if(!empty($_REQUEST['code']) ) {
          $_REQUEST['code'] = strtoupper($_REQUEST['code']);
          $existing = Db::i()->getRow("
SELECT * FROM promo_code WHERE `code` LIKE ?s AND `name` IS NULL ", $_REQUEST['code']);
          if(!empty($existing['id'])) {
            $result = Db::i()->query("
UPDATE promo_code SET `status` = 1 WHERE id = ?i", $existing['id']);
          } else {
            $result = Db::i()->query("
INSERT INTO promo_code
(`code`, email, phone, `name`, vk_id, ip, activated, paid, `status`) VALUES 
( ?s,     NULL,   NULL ,    NULL,     NULL,   NULL, 0,          0,    1) 
", $_REQUEST['code']);
          }
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


$promos = Db::i()->getAll("SELECT * FROM promo_code WHERE status = 1 ORDER BY `activated` DESC, `date` DESC");
$promo_statistics = array();

$promo_services = Config::$PROMO_SERVICES;

$promo_sources = Config::$PROMO_SOURCES;

?>

<h1 class="toggle_next page-header">Використані промо</h1>
<div class="table-responsive">
  <table class="table table-striped used_promo">
    <thead>
    <tr>
      <th>Дата</th>
      <th>Код</th>
      <th>Ім'я</th>
      <th>Телефон</th>
      <th>Vk</th>
      <th>Активований</th>
      <th>Оплачений</th>
      <th>Видалити</th>
    </tr>
    </thead>
    <tbody>
    <?
    $totalstr = "Всього";
    foreach ( $promos as $promo ) {
      $date = date('m/Y', strtotime($promo['date']) );
      $dates = array(
          $date,
          $totalstr
      );


      $service_id = $promo['code'][Config::$SERVICE_POSITION];
      $service_arr = empty($promo_services[ $service_id ])
          ? array()
          : $promo_services[$service_id];
      $service = empty($service_arr['name']) ? ' Не указано' : '  ' .$service_arr['name'];
      $service_discount = empty($service_arr['discount']) ? '' : $service_arr['discount'];
      $services = array(
          $service,
          $totalstr
      );

      $source_id = $promo['code'][Config::$SOURCE_POSITION];
      $source = empty($promo_sources[$source_id])
          ? array()
          : $promo_sources[$source_id];
      $source = empty($source) ? ' Не вказано' : '  '.$source;
//      $source = empty($source_arr['name']) ? 'Не указано' : $source_arr['name'];
//      $source_discount = empty($source_arr['discount']) ? '' : $source_arr['discount'];
      $sources = array(
          $source,
          $totalstr
      );

      foreach ($dates as $date) {
        foreach ($sources as $source) {
          foreach ($services as $service) {
            $promo_statistics[$date][$source][$service]['activated'] =
                empty($promo_statistics[$date][$source][$service]['activated'])
                    ? intval($promo['activated'])
                    : $promo_statistics[$date][$source][$service]['activated'] + intval($promo['activated']);

            $promo_statistics[$date][$source][$service]['paid'] =
                empty($promo_statistics[$date][$source][$service]['paid'])
                    ? intval($promo['paid'])
                    : $promo_statistics[$date][$source][$service]['paid'] + intval($promo['paid']);

            $promo_statistics[$date][$source][$service]['total'] =
                empty($promo_statistics[$date][$source][$service]['total'])
                    ? 1
                    : $promo_statistics[$date][$source][$service]['total'] + 1;
          }
        }
      }
      if(empty($promo['name'])) {
        continue;
      }
      ?>
      <tr data-id="<?= $promo['id'] ?>">
        <td><?= date('d/m H:i', strtotime($promo['date']) ) ?></td>
        <td><?= $promo['code'] ?></td>
        <td><input name="name" value="<?= $promo['name'] ?>"></td>
        <td><?= $promo['phone'] ?></td>
        <td><a href="//vk.com/id<?= $promo['vk_id'] ?>"><?= $promo['vk_id'] ?></a></td>
        <td><input name="activated"
                   type="checkbox"
              <?= $promo['activated'] ? 'checked="checked" ' : '' ?>
          >
        </td>
        <td><input name="paid"
                   type="checkbox"
              <?= $promo['paid'] ? 'checked="checked" ' : '' ?>
          >
        </td>
        <td><button name="status" value="0" type="button">Видалити</button> </td>
      </tr>
    <? } ?>
    </tbody>
  </table>
</div>

<h2 class="toggle_next sub-header">Доступні промо</h2>
<div class="table-responsive">
  <table class="table table-striped">
    <thead>
    <tr>
      <th>Дата</th>
      <th>Код</th>
      <th>Имя</th>
      <th>Телефон</th>
      <th>Vk</th>
      <th>Активирован</th>
      <th>Оплачен</th>
      <th>Удалить</th>
    </tr>
    </thead>
    <tbody class="add_promo">
    <tr data-id="0">
      <td></td>
      <td><input name="code" value=""></td>
      <td><input name="name" type="hidden" value=""></td>
      <td><input name="phone" type="hidden" value=""></td>
      <td><input name="vk_id" type="hidden" value=""></td>
      <td><input name="activated" type="hidden" value="0"></td>
      <td><input name="paid" type="hidden" value="0"></td>
      <td><button name="status" value="1" type="button">Додати</button> </td>
    </tr>
    </tbody>
    <tbody class="used_promo">
    <?
    foreach ( $promos as $promo ) {
      if(!empty($promo['name'])) {
        continue;
      }
      ?>
      <tr data-id="<?= $promo['id'] ?>">
        <td><?= date('d/m H:i', strtotime($promo['date']) ) ?></td>
        <td><input name="code" value="<?= $promo['code'] ?>"></td>
        <td><input name="name"  type="hidden" value="<?= $promo['name'] ?>"></td>
        <td><input name="phone"  type="hidden" value="<?= $promo['phone'] ?>"></td>
        <td><input name="vk_id"  type="hidden" value="<?= $promo['vk_id'] ?>"></td>
        <td><input name="activated"
                   type="checkbox"
              <?= $promo['activated'] ? 'checked="checked" ' : '' ?>
          >
        </td>
        <td><input name="paid"
                   type="checkbox"
              <?= $promo['paid'] ? 'checked="checked" ' : '' ?>
          >
        </td>
        <td><button name="status" value="0" type="button">Видалити</button> </td>
      </tr>
    <? } ?>
    </tbody>
  </table>
</div>


<h2 class="toggle_next sub-header">Статистика промо</h2>
<div class="container-fluid">
  <div class="row sub-header">
    <div class="col-xs-1">
      Місяць
    </div>
    <div class="col-xs-11">
      Статистика
    </div>
  </div>
  <?
  ksort($promo_statistics);
  foreach ($promo_statistics as $date => $p_sources) { ?>
    <div class="row sub-header">
      <div class="col-xs-1">
        <?= $date ?>
      </div>
      <div class="col-xs-11">
        <div class="row sub-header">
          <div class="col-xs-3">Партнер</div>
          <div class="col-xs-9"></div>
        </div>
        <?
        ksort($p_sources);
        foreach($p_sources as $p_source => $p_services) { ?>
          <div class="row sub-header">
            <div class="col-xs-3"><?= $p_source ?></div>
            <div class="col-xs-9">
              <div class="row sub-header">
                <div class="col-xs-3">Вид послуги</div>
                <div class="col-xs-3">Оплачено</div>
                <div class="col-xs-3">Активовано</div>
                <div class="col-xs-3">Всього</div>
              </div>
              <?
              ksort($p_services);
              foreach($p_services as $p_service => $p_counts ) { ?>
                <div class="row sub-header">
                  <div class="col-xs-3"><?= $p_service ?></div>
                  <div class="col-xs-3"><?= $p_counts['paid'] ?></div>
                  <div class="col-xs-3"><?= $p_counts['activated'] ?></div>
                  <div class="col-xs-3"><?= $p_counts['total'] ?></div>
                </div>
              <? } ?>
            </div>
          </div>
        <? } ?>
      </div>
    </div>
  <? } ?>

</div>
