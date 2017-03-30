<?php
/**
 * Created by PhpStorm.
 * User: shikon
 * Date: 29.03.17
 * Time: 17:21
 */

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


$promos = Db::i()->getAll("SELECT * FROM promo_code WHERE status = 1 ORDER BY `activated` DESC, `date` DESC");
$promo_statistics = array();

$promo_services = Config::$PROMO_SERVICES;

$promo_sources = Config::$PROMO_SOURCES;

?>

<h1 class="page-header">Использованные промо</h1>
<div class="table-responsive">
  <table class="table table-striped used_promo">
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
    <tbody>
    <?
    $totalstr = "Всего";
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
      $source = empty($source) ? ' Не указано' : '  '.$source;
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

      ?>
      <tr data-id="<?= $promo['id'] ?>">
        <td><?= date('d/m H:i', strtotime($promo['date']) ) ?></td>
        <td><?= $promo['code'] ?></td>
        <td><?= $promo['name'] ?></td>
        <td><?= $promo['phone'] ?></td>
        <td><?= $promo['vk_id'] ?></td>
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
        <td><button name="status" value="0" type="button">Удалить</button> </td>
      </tr>
    <? } ?>
    </tbody>
  </table>
</div>


<h2 class="sub-header">Статистика промо</h2>
<div class="container-fluid">
  <div class="row sub-header">
    <div class="col-xs-1">
      Месяц
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
                <div class="col-xs-3">Вид услуги</div>
                <div class="col-xs-3">Оплачено</div>
                <div class="col-xs-3">Активировано</div>
                <div class="col-xs-3">Всего</div>
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
